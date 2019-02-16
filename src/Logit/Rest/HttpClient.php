<?php

namespace Logit\Rest;

use Logit\Exception\NoApiKeyException;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;

/**
 * Class HttpClient
 *
 * @package ActiveTrail\Rest
 */
class HttpClient {

  const CONNECTION_TIMEOUT = 5;

  const REQUEST_TIMEOUT = 10;

  const RETRY_LIMIT = 5;

  const BACKOFF_EXPONENT = 2;

  private $apiKey;
  private $retryCounter;

  /**
   * HttpClient constructor.
   *
   * @param $apiToken
   */
  public function __construct($apiKey) {
    $this->apiKey = $apiKey;
  }

  /**
   * General method for making API calls to ActiveTrail via GuzzleHttp.
   *
   * @param $endpoint
   * @param $method
   * @param $payload
   * @param null $endpoint_params
   *
   * @return \GuzzleHttp\Psr7\Response
   * @throws \Exception
   */
  public function MakeLogitApiCall($endpoint = NULL, $method = NULL, $payload = NULL, $endpoint_params = NULL, $extra_headers = []) {

    // First, make sure we have an authorization token
    if (empty($this->apiKey)) {
      throw new NoApiKeyException('You must provide an Api Token.');
    }

    $handlerStack = HandlerStack::create(new CurlHandler());
    $handlerStack->push(Middleware::retry($this->retryDecider(), $this->retryDelay()));

    // Process any endpoint params
    if (!empty($endpoint_params)) {
      foreach ($endpoint_params as $param_name => $param_value) {
        $endpoint = str_replace(':' . $param_name, $param_value, $endpoint);
      }
    }

    $client = new Client(['base_uri' => EndPoints::$API_BASE['uri'], 'handler' => $handlerStack]);

    $request_options = [
      'connect_timeout' => self::CONNECTION_TIMEOUT,
      'timeout' => self::REQUEST_TIMEOUT,
      'headers' => [],
    ];

    // Add additional headers if any were passed.
    if (!empty($extra_headers)) {
      $request_options['headers'] = $extra_headers;
    }

    // Add ApiKey header to top
    $request_options['headers'] = array_merge(['ApiKey' => $this->apiKey], $request_options['headers']);

    // Add payload if one was provided.
    if (!empty($payload)) {
      $request_options['json'] = $payload;
    }

    // Set method and endpoint uri
    $endpoint = empty($endpoint) ? EndPoints::$API_BASE['uri'] : $endpoint;
    $method = empty($method) ? EndPoints::$API_BASE['method'] : $method;

    return $client->request($method, $endpoint, $request_options);

  }

  /**
   * Decides whether to perform a retry
   *
   * @return \Closure
   */
  public function retryDecider() {
    return function (
      $retries,
      Request $request,
      Response $response = NULL,
      RequestException $exception = NULL
    ) {
      // Limit the number of retries to 5
      if ($retries >= self::RETRY_LIMIT) {
        return FALSE;
      }

      // Retry connection exceptions
      if ($exception instanceof ConnectException) {
        return TRUE;
      }

      if ($response) {
        // Retry on server errors
        if ($response->getStatusCode() >= 500) {
          return TRUE;
        }
      }

      return FALSE;
    };
  }

  /**
   * delay 2s 4s 8s 16s 32s
   *
   * @return Closure
   */
  public function retryDelay() {
    return function ($retryCount) {
      return (pow(self::BACKOFF_EXPONENT, $retryCount) * 1000);
    };
  }

}
