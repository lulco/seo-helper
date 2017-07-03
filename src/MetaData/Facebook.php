<?php

namespace SeoHelper\MetaData;

/**
 * @method BaseMetaData setOgTitle(string $ogTitle)
 * @method BaseMetaData addOgTitle(string $ogTitle)
 * @method BaseMetaData setOgDescription(string $ogDescription)
 * @method BaseMetaData addOgDescription(string $ogDescription)
 * @method BaseMetaData setOgType(string $ogType)
 * @method BaseMetaData setOgUrl(string $ogUrl)
 * @method BaseMetaData setOgImage(string $image)
 * @method BaseMetaData addOgImage(string $image)
 * @method BaseMetaData setFbAdmins(string $fbAdmins)
 */
trait Facebook
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

    public function setOgSiteName($siteName)
    {
        return $this->set('og:site_name', $siteName);
    }

    public function getOgSiteName()
    {
        return $this->get('og:site_name');
    }
}
