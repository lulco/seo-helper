<?php

declare(strict_types=1);

namespace SeoHelper\MetaData;

/**
 * @method BaseMetaData addTwitterTitle(string $twitterTitle)
 * @method BaseMetaData setTwitterTitle(string $twitterTitle)
 * @method BaseMetaData resetTwitterTitle(string|null $twitterTitle = null)
 * @method BaseMetaData addTwitterDescription(string $twitterDescription)
 * @method BaseMetaData setTwitterDescription(string $twitterDescription)
 * @method BaseMetaData resetTwitterDescription(string|null $twitterDescription = null)
 * @method BaseMetaData setTwitterCard(string $twitterCard)
 * @method BaseMetaData setTwitterSite(string $twitterSite)
 * @method BaseMetaData setTwitterImage(string $twitterImage)
 * @method BaseMetaData resetTwitterImage(string|null $twitterImage = null)
 * @method BaseMetaData setTwitterCreator(string $twitterCreator)
 */
trait Twitter
{
    abstract public function set(string $key, string|array $value): static;

    abstract public function get(?string $key = null): ?array;
}
