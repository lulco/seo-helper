<?php

declare(strict_types=1);

namespace SeoHelper\Generator;

use SeoHelper\Renderer\DefaultRenderer;
use SeoHelper\Renderer\FacebookRenderer;
use SeoHelper\Renderer\TwitterRenderer;
use function array_merge;
use function ksort;

class DefaultGenerator extends BaseGenerator
{
    public function __construct()
    {
        $this->addRenderer(new DefaultRenderer());
        $this->addRenderer(new FacebookRenderer());
        $this->addRenderer(new TwitterRenderer());
    }

    protected function sortMetaData(array $metaData): array
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
