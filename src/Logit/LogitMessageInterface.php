<?php

namespace Logit;

interface LogitMessageInterface {

  /**
   * Submits the campaign to active trail.
   */
  public function send();

  /**
   * @param string $type
   * @return static
   */
  public function setType($type);

  /**
   * @param mixed $body
   * @return static
   */
  public function setBody($body);

  /**
   * @param mixed $source
   * @return static
   */
  public function setSource($source);

  /**
   * @param mixed $target
   * @return static
   */
  public function setTarget($target);

  /**
   * @param mixed $action
   * @return static
   */
  public function setAction($action);

  /**
   * @param mixed $created
   * @return static
   */
  public function setCreated($created);

  /**
   * @param mixed $code
   * @return static
   */
  public function setCode($code);

  /**
   * @param mixed $errorMessage
   * @return static
   */
  public function setErrorMessage($errorMessage);

}
