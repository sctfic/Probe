<?php


/**
 * Simple solution for: "Fatal error: Can't use function return value in
 * write context in ..."
 *
 * @param $val
 *
 * @return bool
 */function _empty($val) { return empty($val); }
