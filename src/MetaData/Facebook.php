<?php

declare(strict_types=1);

namespace SeoHelper\MetaData;

/**
 * @method BaseMetaData addOgTitle(string $ogTitle)
 * @method BaseMetaData setOgTitle(string $ogTitle)
 * @method BaseMetaData resetOgTitle(string|null $ogTitle = null)
 * @method BaseMetaData addOgDescription(string $ogDescription)
 * @method BaseMetaData setOgDescription(string $ogDescription)
 * @method BaseMetaData resetOgDescription(string|null $ogDescription = null)
 * @method BaseMetaData setOgType(string $ogType)
 * @method BaseMetaData setOgUrl(string $ogUrl)
 * @method BaseMetaData addOgImage(string $image)
 * @method BaseMetaData setOgImage(string $image)
 * @method BaseMetaData resetOgImage(string|null $image = null)
 * @method BaseMetaData setFbAdmins(string $fbAdmins)
 * @method BaseMetaData setFbPages(string $fbPages)
 */
trait Facebook
{
    abstract public function set(string $key, string|array $value): static;

    abstract public function get(?string $key = null): ?array;

    public function setOgSiteName(string $siteName): static
    {
        return $this->set('og:site_name', $siteName);
    }

    public function getOgSiteName(): ?array
    {
        return $this->get('og:site_name');
    }

    public function setFbAppId($appId): static
    {
        return $this->set('fb:app_id', $appId);
    }

    public function getFbAppId(): ?array
    {
        return $this->get('fb:app_id');
    }
}
