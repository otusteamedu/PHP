<?php

namespace Controllers;

use ArrayAccess;
use Exceptions\RestClientException;
use Iterator;

class RestAPIController implements Iterator, ArrayAccess
{
    public $options;
    public $handle;

    public $response;
    public $headers;
    public $info;
    public $error;
    public $response_status_lines;

    public $decoded_response;
    private $url;

    public function __construct($options = [])
    {
        $default_options = [
            'headers' => [],
            'parameters' => [],
            'curl_options' => [],
            'build_indexed_queries' => false,
            'user_agent' => "PHP RestClient/0.1.7",
            'base_url' => null,
            'format' => null,
            'format_regex' => "/(\w+)\/(\w+)(;[.+])?/",
            'decoders' => [
                'json' => 'json_decode',
                'php' => 'unserialize'
            ],
            'username' => null,
            'password' => null
        ];

        $this->options = array_merge($default_options, $options);
        if (array_key_exists('decoders', $options)) {
            $this->options['decoders'] = array_merge(
                $default_options['decoders'],
                $options['decoders']
            );
        }
    }

    public function setOption($key, $value)
    {
        $this->options[$key] = $value;
    }

    /**
     * @param $format
     * @param $method
     */
    public function registerDecoder($format, $method)
    {
        $this->options['decoders'][$format] = $method;
    }

    /**
     * @return mixed|void
     * @throws RestClientException
     */
    public function rewind()
    {
        $this->decodeResponse();
        return reset($this->decoded_response);
    }

    /**
     * @return mixed
     * @throws RestClientException
     */
    public function decodeResponse()
    {
        if (empty($this->decoded_response)) {
            $format = $this->get_response_format();
            if (!array_key_exists($format, $this->options['decoders'])) {
                throw new RestClientException("'${format}' is not a supported " .
                    "format, register a decoder to handle this response.");
            }

            $this->decoded_response = call_user_func(
                $this->options['decoders'][$format],
                $this->response
            );
        }

        return $this->decoded_response;
    }

    /**
     * @return mixed
     * @throws RestClientException
     */
    public function get_response_format()
    {
        if (!$this->response) {
            throw new RestClientException(
                "A response must exist before it can be decoded."
            );
        }

        if (!empty($this->options['format'])) {
            return $this->options['format'];
        }

        if (!empty($this->headers->content_type)) {
            if (preg_match($this->options['format_regex'], $this->headers->content_type, $matches)) {
                return $matches[2];
            }
        }

        throw new RestClientException(
            "Response format could not be determined."
        );
    }

    public function current()
    {
        return current($this->decoded_response);
    }

    public function key()
    {
        return key($this->decoded_response);
    }

    public function next()
    {
        return next($this->decoded_response);
    }

    public function valid()
    {
        return is_array($this->decoded_response)
            && (key($this->decoded_response) !== null);
    }

    /**
     * @param mixed $key
     * @return mixed|null
     * @throws RestClientException
     */
    public function offsetGet($key)
    {
        $this->decodeResponse();
        if (!$this->offsetExists($key)) {
            return null;
        }

        return is_array($this->decoded_response) ?
            $this->decoded_response[$key] : $this->decoded_response->{$key};
    }

    /**
     * @param mixed $key
     * @return bool
     * @throws RestClientException
     */
    public function offsetExists($key)
    {
        $this->decodeResponse();
        return is_array($this->decoded_response) ?
            isset($this->decoded_response[$key]) : isset($this->decoded_response->{$key});
    }

    /**
     * @param mixed $key
     * @param mixed $value
     * @throws RestClientException
     */
    public function offsetSet($key, $value)
    {
        throw new RestClientException("Decoded response data is immutable.");
    }

    /**
     * @param mixed $key
     * @throws RestClientException
     */
    public function offsetUnset($key)
    {
        throw new RestClientException("Decoded response data is immutable.");
    }

    public function get($url, $parameters = [], $headers = [])
    {
        return $this->execute($url, 'GET', $parameters, $headers);
    }

    public function execute($url, $method = 'GET', $parameters = [], $headers = [])
    {
        $client = clone $this;
        $client->url = $url;
        $client->handle = curl_init();
        $curlopt = [
            CURLOPT_HEADER => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_USERAGENT => $client->options['user_agent']
        ];

        if ($client->options['username'] && $client->options['password']) {
            $curlopt[CURLOPT_USERPWD] = sprintf(
                "%s:%s",
                $client->options['username'],
                $client->options['password']
            );
        }

        if (count($client->options['headers']) || count($headers)) {
            $curlopt[CURLOPT_HTTPHEADER] = [];
            $headers = array_merge($client->options['headers'], $headers);
            foreach ($headers as $key => $values) {
                foreach (is_array($values) ? $values : [$values] as $value) {
                    $curlopt[CURLOPT_HTTPHEADER][] = sprintf("%s:%s", $key, $value);
                }
            }
        }

        if ($client->options['format']) {
            $client->url .= '.' . $client->options['format'];
        }

        // Allow passing parameters as a pre-encoded string (or something that
        // allows casting to a string). Parameters passed as strings will not be
        // merged with parameters specified in the default options.
        if (is_array($parameters)) {
            $parameters = array_merge($client->options['parameters'], $parameters);
            $parameters_string = http_build_query($parameters);

            // http_build_query automatically adds an array index to repeated
            // parameters which is not desirable on most systems. This hack
            // reverts "key[0]=foo&key[1]=bar" to "key[]=foo&key[]=bar"
            if (!$client->options['build_indexed_queries']) {
                $parameters_string = preg_replace(
                    "/%5B[0-9]+%5D=/simU",
                    "%5B%5D=",
                    $parameters_string
                );
            }
        } else {
            $parameters_string = (string)$parameters;
        }

        if (strtoupper($method) == 'POST') {
            $curlopt[CURLOPT_POST] = true;
            $curlopt[CURLOPT_POSTFIELDS] = $parameters_string;
        } elseif (strtoupper($method) != 'GET') {
            $curlopt[CURLOPT_CUSTOMREQUEST] = strtoupper($method);
            $curlopt[CURLOPT_POSTFIELDS] = $parameters_string;
        } elseif ($parameters_string) {
            $client->url .= strpos($client->url, '?') ? '&' : '?';
            $client->url .= $parameters_string;
        }

        if ($client->options['base_url']) {
            if ($client->url[0] != '/' && substr($client->options['base_url'], -1) != '/') {
                $client->url = '/' . $client->url;
            }
            $client->url = $client->options['base_url'] . $client->url;
        }
        $curlopt[CURLOPT_URL] = $client->url;

        if ($client->options['curl_options']) {
            // array_merge would reset our numeric keys.
            foreach ($client->options['curl_options'] as $key => $value) {
                $curlopt[$key] = $value;
            }
        }
        curl_setopt_array($client->handle, $curlopt);

        $client->parseResponse(curl_exec($client->handle));
        $client->info = (object)curl_getinfo($client->handle);
        $client->error = curl_error($client->handle);

        curl_close($client->handle);
        return $client;
    }

    public function parseResponse($response)
    {
        $headers = [];
        $this->response_status_lines = [];
        $line = strtok($response, "\n");
        do {
            if (strlen(trim($line)) == 0) {
                // Since we tokenize on \n, use the remaining \r to detect empty lines.
                if (count($headers) > 0) {
                    break; // Must be the newline after headers, move on to response body
                }
            } elseif (strpos($line, 'HTTP') === 0) {
                // One or more HTTP status lines
                $this->response_status_lines[] = trim($line);
            } else {
                // Has to be a header
                list($key, $value) = explode(':', $line, 2);
                $key = trim(strtolower(str_replace('-', '_', $key)));
                $value = trim($value);

                if (empty($headers[$key])) {
                    $headers[$key] = $value;
                } elseif (is_array($headers[$key])) {
                    $headers[$key][] = $value;
                } else {
                    $headers[$key] = [$headers[$key], $value];
                }
            }
        } while ($line = strtok("\n"));

        $this->headers = (object)$headers;
        $this->response = strtok("");
    }

    public function post($url, $parameters = [], $headers = [])
    {
        return $this->execute($url, 'POST', $parameters, $headers);
    }

    public function put($url, $parameters = [], $headers = [])
    {
        return $this->execute($url, 'PUT', $parameters, $headers);
    }

    public function patch($url, $parameters = [], $headers = [])
    {
        return $this->execute($url, 'PATCH', $parameters, $headers);
    }

    public function delete($url, $parameters = [], $headers = [])
    {
        return $this->execute($url, 'DELETE', $parameters, $headers);
    }

    public function head($url, $parameters = [], $headers = [])
    {
        return $this->execute($url, 'HEAD', $parameters, $headers);
    }
}
