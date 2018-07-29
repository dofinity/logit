<?php

namespace Logit;

/**
 * Trait JsonSerializableTrait
 *
 * @package Logit
 */
trait JsonSerializableTrait {

  /**
   * Return JSON serialized data
   * @return array
   */
  public function jsonSerialize() {

    $object = array_filter(get_object_vars($this), function ($val) {
      return !is_null($val);
    });

    return $object;

  }

}