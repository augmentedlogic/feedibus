# php-feedit

Originally a fork of [https://github.com/suin/php-rss-writer](suin/php-rss-writer) (July 2026), work in progress

# Changelog

v0.2

* added ChannelImage class
* some preliminary typing for php 8

## Usage

```php
$feed = new Feed();

$channelImage = new ChannelImage();
$channelImage->url("https://example.com/icon.png")
             ->link("https://example.com/icon.png")
             ->title("Acme Ltd Logo");



$channel = new Channel();
$channel
    ->title('Channel Title')
    ->description('Channel Description')
    ->url('http://blog.example.com')
    ->feedUrl('http://blog.example.com/rss')
    ->language('en-US')
    ->image($channelImage)
    ->copyright('Copyright 2012, Foo Bar')
    ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
    ->lastBuildDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
    ->ttl(60)
    ->pubsubhubbub('http://example.com/feed.xml', 'http://pubsubhubbub.appspot.com') // This is optional. Specify PubSubHubbub discovery if you want.
    ->appendTo($feed);

// Blog item
$item = new Item();
$item
    ->title('Blog Entry Title')
    ->description('<div>Blog body</div>')
    ->contentEncoded('<div>Blog body</div>')
    ->url('http://blog.example.com/2012/08/21/blog-entry/')
    ->author('John Smith')
    ->pubDate(strtotime('Tue, 21 Aug 2012 19:50:37 +0900'))
    ->guid('http://blog.example.com/2012/08/21/blog-entry/', true)
    ->preferCdata(true) // By this, title and description become CDATA wrapped HTML.
    ->appendTo($channel);


// Podcast item
$item = new Item();
$item
    ->title('Some Podcast Entry')
    ->description('<div>Podcast body</div>')
    ->url('http://podcast.example.com/2012/08/21/podcast-entry/')
    ->enclosure('http://podcast.example.com/2012/08/21/podcast.mp3', 4889, 'audio/mpeg')
    ->appendTo($channel);




echo $feed; // or echo $feed->render();
```

Output:

```xml
<?xml version="1.0" encoding="UTF-8"?>
<rss xmlns:content="http://purl.org/rss/1.0/modules/content/" xmlns:atom="http://www.w3.org/2005/Atom" version="2.0">
  <channel>
    <title>Channel Title</title>
    <link>http://blog.example.com</link>
    <description>Channel Description</description>
    <language>en-US</language>
    <image>
      <url>https://example.com/icon.png</url>
      <title>Acme Ltd Logo</title>
      <link>https://example.com/icon.png</link>
    </image>
    <copyright>Copyright 2012, Foo Bar</copyright>
    <pubDate>Tue, 21 Aug 2012 10:50:37 +0000</pubDate>
    <lastBuildDate>Tue, 21 Aug 2012 10:50:37 +0000</lastBuildDate>
    <ttl>60</ttl>
    <atom:link rel="self" href="http://example.com/feed.xml" type="application/rss+xml"/>
    <atom:link rel="hub" href="http://pubsubhubbub.appspot.com"/>
    <item>
      <title><![CDATA[Blog Entry Title]]></title>
      <link>http://blog.example.com/2012/08/21/blog-entry/</link>
      <description><![CDATA[<div>Blog body</div>]]></description>
      <content:encoded><![CDATA[<div>Blog body</div>]]></content:encoded>
      <guid>http://blog.example.com/2012/08/21/blog-entry/</guid>
      <pubDate>Tue, 21 Aug 2012 10:50:37 +0000</pubDate>
      <author>John Smith</author>
    </item>
    <item>
      <title>Some Podcast Entry</title>
      <link>http://podcast.example.com/2012/08/21/podcast-entry/</link>
      <description>&lt;div&gt;Podcast body&lt;/div&gt;</description>
      <enclosure url="http://podcast.example.com/2012/08/21/podcast.mp3" type="audio/mpeg" length="4889"/>
    </item>
  </channel>
</rss>
```

## License

MIT license
