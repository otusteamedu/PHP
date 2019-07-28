<?php

namespace AnrDaemon\CcWeb\Interfaces;

/** Request controller interface
*
* The controller must process the request and supposedly produce a response.
*/
interface Controller
{
  /** Creates the instance with optional routing metadata
  *
  * The metadata usually includes query parameters.
  *
  * @param SettingsManager $config The application configuration DTO.
  * @param ?mixed $meta The instance-appropriate metadata.
  * @return self The instance prepared to act on a given metadata.
  */
  public static function create(SettingsManager $config, $meta = null)/*TODO:PHP7 : self*/;

  /** Query the initialized instance metadata
  *
  * Returned array MAY contain the following keys
  *   scheme
  *   user
  *   host
  *   port
  *   path
  *   query
  *   fragment
  * with meaning equal to that of {@see \parse_url() parse_url()} and with the same intention -
  * to construct the final "canonical" URI for a given location.
  *
  * If an array is returned, it SHOULD contain at least 'path' element -
  * the canonical resource location WITHOUT parameters.
  * Instance MAY choose to redirect the request to this path, if request
  * method allows for safe redirection.
  *
  * Return value MAY be null, if "canonical URL" is not a meaningful
  * category for a given implementation, like for an error page handler.
  *
  * @return ?mixed Instance metadata.
  */
  public function getMetadata();

  /** Set the instance metadata
  *
  * Acceps either routing metadata or an initial "instance-appropriate" data.
  * This may be RoutingException, for example.
  *
  * Returns the Controller instance prepared to serve the request.
  *
  * Return value MAY be the same instance, but this is not recommended for
  * portability reasons.
  *
  * Dispatchers MUST use the instance returned by this method to dispatch
  * the request.
  *
  * @param mixed $meta The instance-appropriate metadata.
  * @return self The instance prepared to act on a given metadata.
  */
  public function setMetadata($meta)/*TODO:PHP7 : self*/;

  /** Executes the controller
  *
  * This is the method that actually handles the request and supposed to
  * output the response.
  * Alternatively, it may generate the RoutingException with appropriate
  * response code.
  *
  * @param ?mixed $data Additional request data. F.e. $_POST data or a reference to the input stream.
  * @return void
  */
  public function run($data = null);
}
