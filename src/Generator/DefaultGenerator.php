<?php

namespace SeoHelper\Generator;

use SeoHelper\MetaData\BaseMetaData;
use SeoHelper\Renderer\DefaultRenderer;
use SeoHelper\Renderer\FacebookRenderer;
use SeoHelper\Renderer\TwitterRenderer;

class DefaultGenerator extends BaseGenerator
{
    public function __construct(BaseMetaData $metaData)
    {
        $this->addRenderer(new DefaultRenderer());
        $this->addRenderer(new FacebookRenderer());
        $this->addRenderer(new TwitterRenderer());
    }
    
    protected function sortMetaData($metaData)
    {
        ksort($metaData);
        $metaDataToPrepend = ['title', 'description', 'keywords', 'robots'];
        $prependedMetaData = [];
        foreach ($metaDataToPrepend as $key) {
            if (!isset($metaData[$key])) {
                continue;
            }
            $prependedMetaData[$key] = $metaData[$key];
            unset($metaData[$key]);
        }
        return array_merge($prependedMetaData, $metaData);
    }
}
