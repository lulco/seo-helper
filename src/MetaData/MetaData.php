<?php

namespace SeoHelper\MetaData;

/**
 * @method BaseMetaData addTitle(string $title)
 * @method BaseMetaData setTitle(string $title)
 * @method BaseMetaData resetTitle(string|null $title = null)
 * @method BaseMetaData addKeywords(string|array $keywords)
 * @method BaseMetaData setKeywords(string|array $keywords)
 * @method BaseMetaData addDescription(string $description)
 * @method BaseMetaData setDescription(string $description)
 * @method BaseMetaData resetDescription(string|null $description = null)
 * @method BaseMetaData setRobots(string $robots)
 * @method BaseMetaData setCanonical(string $canonicalUrl)
 */
class MetaData extends BaseMetaData
{
    use Facebook;
    use Twitter;
}
