<?php
/**
 * Array Helper
 *
 * @category Helper
 * @package  Probe
 * @author   Édouard Lopez <dev+probe@edouard-lopez.com>
 * @license  http://creativecommons.org/licenses/by-nc-sa/3.0/legalcode CC-by-nc-sa-3.0
 * @link     http://probe.com/doc
 */


/**
 * Get the last item (key => value) from an array.
 * Can be used to detected last item.
 *
 * @param $array
 *
 * @return array
 */function getLast($array) {
    end($array); // move pointer to the
    $lastItem = each($array); // fetch the item

    return $lastItem;
}

/**
 * Get the last *key* from an array. Can be used to detected last item
 *
 * @param $item
 *
 * @return array
 */function getLastKey($item) {
    return key($item);
}

/**
 * Get the last *value* from an array. Can be used to detected last item
 *
 * @param $item
 *
 * @return array
 */function getLastValue($item) {
    return current($item);
}