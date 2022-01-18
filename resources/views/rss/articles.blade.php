<?=
'<?xml version="1.0" encoding="UTF-8"?>'.PHP_EOL
?>
<rss version="2.0">
    <channel>
        <title><![CDATA[ TechDiary ]]></title>
        <link><![CDATA[ https://api.techdiary.dev/rss/articles ]]></link>
        <description><![CDATA[ TechDiary articles RSS Feed ]]></description>
        <language>bn</language>
        <pubDate>{{ now() }}</pubDate>

        @foreach($articles as $article)
            <item>
                <title><![CDATA[{{ $article->title }}]]></title>
                <link>{{ $article->url }}</link>
                <description><![CDATA[{!! $article->bodyHtml !!}]]></description>
{{--                <category>{{ $article->category }}</category>--}}
                <author><![CDATA[{{ $article->user->username  }}]]></author>
                <guid>{{ $article->id }}</guid>
                <pubDate>{{ $article->created_at->toRssString() }}</pubDate>
            </item>
        @endforeach
    </channel>
</rss>