<?php

namespace App\TechDiary;

use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\Extension\Table\TableExtension;
use Torchlight\Commonmark\V2\TorchlightExtension;



class TDMarkdown
{

    public $markdown;

    /**
     * @param $markdown
     */
    public function __construct($markdown)
    {
        $this->markdown = $markdown;
    }



    /**
     * Generate html of given markdown
     * @return string
     */
    public function toHTML()
    {
        $config = [
            'heading_permalink' => [
                'html_class' => 'heading-permalink',
                'id_prefix' => 'content',
                'fragment_prefix' => 'content',
                'insert' => 'before',
                'min_heading_level' => 1,
                'max_heading_level' => 6,
                'title' => 'Permalink',
                'symbol' => HeadingPermalinkRenderer::DEFAULT_SYMBOL
            ],
        ];




        $converter = new CommonMarkConverter($config);
        $converter->getEnvironment()->addExtension(new HeadingPermalinkExtension);
        $converter->getEnvironment()->addExtension(new TableExtension);
//        $converter->getEnvironment()->addExtension(new TorchlightExtension);

        return $converter->convertToHtml($this->markdown);
    }

}
