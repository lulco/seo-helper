<?php

namespace SeoHelper\MetaData;

/**
 * @method BaseMetaData setTitle(string $title)
 * @method BaseMetaData addTitle(string $title)
 * @method BaseMetaData setKeywords(string|array $keywords)
 * @method BaseMetaData addKeywords(string|array $keywords)
 * @method BaseMetaData setDescription(string $description)
 * @method BaseMetaData addDescription(string $description)
 * @method BaseMetaData setRobots(string $robots)
 * @method BaseMetaData setCanonical(string $canonicalUrl)
 */
class MetaData extends BaseMetaData
{
    use Facebook;
    use Twitter;
}
