<?php

namespace Happgo\Lib;

use function array_pop;
use function explode;
use function implode;
use function str_replace;
use function strpos;
use function substr;
use const DIRECTORY_SEPARATOR;

/**
 * Class FSHelper - file system helper
 *
 * @since 2.0
 */
class FSHelper
{
    /**
     * 返回绝对路径的
     * Convert 'this/is/../a/./test/.///is' to 'this/a/test/is'
     *
     * @param string $path
     * @param bool   $filter
     *
     * @return string
     */
    public static function conv2abs(string $path, bool $filter = true): string
    {
        $path = str_replace('\\', '/', $path);

        if (strpos($path, '..') === false) {
            return $path;
        }

        $first = '';
        $parts = explode('/', $path);
        if ($filter) {
            $first = $path[0] === '/' ? '/' : '';
            $parts = array_filter($parts, 'strlen');
        }

        $absolutes = [];
        foreach ($parts as $part) {
            if ('.' === $part) {
                continue;
            }

            if ('..' === $part) {
                array_pop($absolutes);
            } else {
                $absolutes[] = $part;
            }
        }

        return $first . implode('/', $absolutes);
    }
}
