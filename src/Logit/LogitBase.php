<?php

namespace Logit;

use Logit\Rest\HttpClient;
use GuzzleHttp\Psr7\Response;

/**
 * Class LogitBase
 *
 * @package Logit
 */
abstract class LogitBase {

  /**
   * @var \Logit\Rest\HttpClient
   */
  protected $client;

  /**
   * @var string
   */
  protected $endpoint;

  /**
   * ActiveTrailApi constructor.
   * @param string $apiToken
   * @param string $endpoint
   */
  public function __construct($api_token, $endpoint = NULL) {
    $this->client = new HttpClient($api_token);
    $this->endpoint = $endpoint;
  }

  /**
   * Helper function to extract the guzzle response and decode it.
   * @param \GuzzleHttp\Psr7\Response $response
   * @return mixed
   */
  protected function getDecodedJsonResponse(Response $response) {
    return json_decode($response->getBody()->getContents());
  }

}
