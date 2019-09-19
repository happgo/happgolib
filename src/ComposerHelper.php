<?php declare(strict_types=1);

namespace Happgo\Lib;

use Composer\Autoload\ClassLoader;
use RuntimeException;

use function is_array;
use function is_object;
use function spl_autoload_functions;

/**
 * Class ComposerHelper
 *
 * @since 2.0
 */
class ComposerHelper
{
    /**
     * @var ClassLoader
     */
    private static $composerLoader;

    /**
     * Get composer class loader
     *
     * @return ClassLoader
     * @throws RuntimeException
     */
    public static function getClassLoader(): ClassLoader
    {
        if (self::$composerLoader) {
            return self::$composerLoader;
        }
        $autoloadFunctions = spl_autoload_functions();

        foreach ($autoloadFunctions as $autoloader) {
            if (is_array($autoloader) && isset($autoloader[0])) {
                $composerLoader = $autoloader[0];

                if (is_object($composerLoader) && $composerLoader instanceof ClassLoader) {
                    self::$composerLoader = $composerLoader;
                    return self::$composerLoader;
                }
            }
        }
        throw new RuntimeException('Composer ClassLoader not found!');
    }
}
