<?php
/**
 * Elasticsearch PHP client
 *
 * @link      https://github.com/elastic/elasticsearch-php/
 * @copyright Copyright (c) Elasticsearch B.V (https://www.elastic.co)
 * @license   http://www.apache.org/licenses/LICENSE-2.0 Apache License, Version 2.0
 * @license   https://www.gnu.org/licenses/lgpl-2.1.html GNU Lesser General Public License, Version 2.1 
 * 
 * Licensed to Elasticsearch B.V under one or more agreements.
 * Elasticsearch B.V licenses this file to you under the Apache 2.0 License or
 * the GNU Lesser General Public License, Version 2.1, at your option.
 * See the LICENSE file in the project root for more information.
 */
declare(strict_types = 1);

namespace Elasticsearch\Namespaces;

use Elasticsearch\Namespaces\AbstractNamespace;

/**
 * Class TextStructureNamespace
 *
 * NOTE: this file is autogenerated using util/GenerateEndpoints.php
 * and Elasticsearch 7.15.0-SNAPSHOT (4e182b9ebb7699ef62d9c632ad58fc16f9828e11)
 */
class TextStructureNamespace extends AbstractNamespace
{

    /**
     * Finds the structure of a text file. The text file must contain data that is suitable to be ingested into Elasticsearch.
     *
     * $params['lines_to_sample']       = (int) How many lines of the file should be included in the analysis (Default = 1000)
     * $params['line_merge_size_limit'] = (int) Maximum number of characters permitted in a single message when lines are merged to create messages. (Default = 10000)
     * $params['timeout']               = (time) Timeout after which the analysis will be aborted (Default = 25s)
     * $params['charset']               = (string) Optional parameter to specify the character set of the file
     * $params['format']                = (enum) Optional parameter to specify the high level file format (Options = ndjson,xml,delimited,semi_structured_text)
     * $params['has_header_row']        = (boolean) Optional parameter to specify whether a delimited file includes the column names in its first row
     * $params['column_names']          = (list) Optional parameter containing a comma separated list of the column names for a delimited file
     * $params['delimiter']             = (string) Optional parameter to specify the delimiter character for a delimited file - must be a single character
     * $params['quote']                 = (string) Optional parameter to specify the quote character for a delimited file - must be a single character
     * $params['should_trim_fields']    = (boolean) Optional parameter to specify whether the values between delimiters in a delimited file should have whitespace trimmed from them
     * $params['grok_pattern']          = (string) Optional parameter to specify the Grok pattern that should be used to extract fields from messages in a semi-structured text file
     * $params['timestamp_field']       = (string) Optional parameter to specify the timestamp field in the file
     * $params['timestamp_format']      = (string) Optional parameter to specify the timestamp format in the file - may be either a Joda or Java time format
     * $params['explain']               = (boolean) Whether to include a commentary on how the structure was derived (Default = false)
     * $params['body']                  = (array) The contents of the file to be analyzed (Required)
     *
     * @param array $params Associative array of parameters
     * @return array
     * @see https://www.elastic.co/guide/en/elasticsearch/reference/current/find-structure.html
     */
    public function findStructure(array $params = [])
    {
        $body = $this->extractArgument($params, 'body');

        $endpointBuilder = $this->endpoints;
        $endpoint = $endpointBuilder('TextStructure\FindStructure');
        $endpoint->setParams($params);
        $endpoint->setBody($body);

        return $this->performRequest($endpoint);
    }
}
