<?php
/**
 * Created by IntelliJ IDEA
 * Author: 张伯发
 * Date  : 2019/9/20
 * Time  : 13:56
 */

namespace Happgo\Lib;


class PhpHelper
{

    public static function call($cb, ...$args)
    {
        if (is_string($cb)) {
            // className::method
            if (strpos($cb, '::') > 0) {
                $cb = explode('::', $cb, 2);
                // function
            } elseif (function_exists($cb)) {
                return $cb(...$args);
            }
        } elseif (is_object($cb) && method_exists($cb, '__invoke')) {
            return $cb(...$args);
        }

        if (is_array($cb)) {
            [$obj, $mhd] = $cb;

            return is_object($obj) ? $obj->$mhd(...$args) : $obj::$mhd(...$args);
        }

        return $cb(...$args);
    }
}