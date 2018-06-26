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
   * @param mixed $content
   * @return static
   */
  public function setSource($content);

  /**
   * @param mixed $content
   * @return static
   */
  public function setTarget($content);

  /**
   * @param mixed $created
   * @return static
   */
  public function setCreated($created);

}
