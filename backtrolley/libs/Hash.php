<?php
class Hash {

  static function generateHashedString($string) {

    $saltedString = $string . HASH_SALT;
    return hash(HASH_ALGO, $saltedString);
  }
}
