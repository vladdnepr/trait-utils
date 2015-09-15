<?php

namespace VladDnepr\TraitUtils;

class TraitUtils
{
    /**
     * Cache results of contain method
     * @var array
     */
    protected static $cache = [];

    /**
     * Return is the trait used by the given class or object
     *
     * @param mixed $object The tested object or class name
     * @param string $trait_class Trait name
     * @return bool
     */
    public static function contain($object, $trait_class)
    {
        $cache_key = md5((is_object($object) ? get_class($object) : $object) . $trait_class);

        if (!isset(self::$cache[$cache_key])) {
            $traits = [];

            do {
                $traits = array_merge($traits, class_uses($object));
            } while ($object = get_parent_class($object));

            self::$cache[$cache_key] = isset($traits[$trait_class]);
        }

        return self::$cache[$cache_key];
    }
}

/**
 * @see TraitContain::contain()
 */
function is_contain_trait($object, $trait_class)
{
    return TraitUtils::contain($object, $trait_class);
}
