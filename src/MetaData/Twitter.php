<?php

namespace SeoHelper\MetaData;

/**
 * @method BaseMetaData setTwitterTitle(string $twitterTitle)
 * @method BaseMetaData addTwitterTitle(string $twitterTitle)
 * @method BaseMetaData setTwitterDescription(string $twitterDescription)
 * @method BaseMetaData addTwitterDescription(string $twitterDescription)
 * @method BaseMetaData setTwitterCard(string $twitterCard)
 * @method BaseMetaData setTwitterSite(string $twitterSite)
 * @method BaseMetaData setTwitterImage(string $twitterImage)
 * @method BaseMetaData setTwitterCreator(string $twitterCreator)
 */
trait Twitter
{
    /**
     * @param string $key
     * @param string|array $value
     */
    abstract public function set($key, $value);

    /**
     * @param string|null $key
     */
    abstract public function get($key = null);
}
