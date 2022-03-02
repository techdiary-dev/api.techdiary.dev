<?php

namespace App\TechDiary\Markdown\Services;

use League\CommonMark\Util\HtmlElement;
use Ueberdosis\CommonMark\Embed;
use Ueberdosis\CommonMark\ServiceInterface;

class CodePen implements ServiceInterface
{
    public const pattern = 'https?.*codepen.io\/(.*)\/pen\/(.*)';


    public function render(Embed $node): HtmlElement
    {
        return new HtmlElement(
            'iframe',
            [
                'src' => 'https://codepen.io/'.$this->getUsername($node->getUrl()).'/embed/' . $this->getId($node->getUrl()),
                'frameborder' => '0',
            ],
        );
    }

    protected function getId($url)
    {
        preg_match('/' . self::pattern . '/', $url, $matches);

        return $matches[2] ?? '';
    }

    public function getUsername($url)
    {
        preg_match('/' . self::pattern . '/', $url, $matches);
        return $matches[1] ?? '';
    }
}