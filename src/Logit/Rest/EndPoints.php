<?php

namespace Logit\Rest;

/**
 * Class RestEndpoints
 *
 * @todo: Generalize. Convert to constant arrays when PHP 5.6 arrives. Possibly convert to define when PHP 7 Arrives.
 */
abstract class EndPoints {

  // Base URI
  public static $API_BASE = ['method' => 'post', 'uri' => 'https://api.logit.io/v2'];

}
