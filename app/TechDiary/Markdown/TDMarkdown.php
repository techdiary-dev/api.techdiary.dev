<?php

namespace App\TechDiary\Markdown;

use App\TechDiary\Markdown\Services\CodePen;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Extension\Autolink\AutolinkExtension;
use League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension;
use League\CommonMark\Extension\ExternalLink\ExternalLinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\Table\TableExtension;
use League\CommonMark\Extension\TableOfContents\TableOfContentsExtension;
use League\CommonMark\Extension\TaskList\TaskListExtension;
use Ueberdosis\CommonMark\EmbedExtension;
use Ueberdosis\CommonMark\Services\Vimeo;
use Ueberdosis\CommonMark\Services\YouTube;

class TDMarkdown
{
    protected $markdown;

    public function __construct($markdown)
    {
        $this->markdown = $markdown;
    }

    /**
     * Generate html of given markdown
     *
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
                'symbol' => '#',
            ],
            'external_link' => [
                'internal_hosts' => env('CLIENT_BASE_URL'),
                'open_in_new_window' => true,
                'html_class' => 'external-link',
            ],
            'table_of_contents' => [
                'html_class' => 'table-of-contents',
                'position' => 'top',
                'style' => 'bullet',
                'min_heading_level' => 1,
                'max_heading_level' => 3,
                'normalize' => 'relative',
                'placeholder' => 'Table of contents',
            ],
            'embeds' => [
                new CodePen(),
                new YouTube(),
                new Vimeo(),
                //                TODO: codesandbox, soundcloud
            ],
        ];
        $converter = new CommonMarkConverter($config);

        $converter->getEnvironment()->addExtension(new HeadingPermalinkExtension());
        $converter->getEnvironment()->addExtension(new TableExtension());
        $converter->getEnvironment()->addExtension(new ExternalLinkExtension());
        $converter->getEnvironment()->addExtension(new AutolinkExtension());
        $converter->getEnvironment()->addExtension(new TaskListExtension());
        $converter->getEnvironment()->addExtension(new DisallowedRawHtmlExtension());
        $converter->getEnvironment()->addExtension(new TableOfContentsExtension());
        $converter->getEnvironment()->addExtension(new EmbedExtension());

        return (string) $converter->convert($this->markdown ?: '');
    }
}
