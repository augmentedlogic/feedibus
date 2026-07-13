# feedibus

This originally started as a a fork of [https://github.com/suin/php-rss-writer](suin/php-rss-writer) (in July 2026), but has become
a project of its own. Aims are to add Channel Image, Media RSS support and php 8 compatibility.

# Changelog

v0.6

* support for MediaRSS (most of it anyway, there are endless options)

v0.5

* namespace change
* now available on packagist

v0.2

* added ChannelImage class
* some preliminary typing for php 8

## Installation

```
composer require augmentedlogic/feedibus
```

## Usage

```php

use com\augmentedlogic\feedibus\Channel;
use com\augmentedlogic\feedibus\ChannelImage;
use com\augmentedlogic\feedibus\Feed;
use com\augmentedlogic\feedibus\Item;


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


// Media RSS item
$mediaitem = new MediaItem();
$mediaitem ->url("https://www.example.com")
           ->title("Oh my wonderful RSS", "plain")
           ->filesize(5020281)
           ->filetype("audio/mpeg")
           ->medium("audio")
           ->width(1920)
           ->height(1080)
           ->bitrate(2500)
           ->framerate(25)
           ->samplingrate(44.1)
           ->channels(2)
           ->lang("en")
           ->thumbnail("https://example.com/image.jpg")
           ->thumbnailWidth(900)
           ->thumbnailHeight(600)
           ->expression("full")
           ->description("a wonderful song")
           ->keywords(array("rock", "blues"))
           ->playerUrl("https://example.com")
           ->playerWidth(1920)
           ->playerHeight(1080);
 
$item = new Item();
$item
    ->title('Some Media RSS Entry')
    ->description('<div>Podcast body</div>')
    ->url('http://podcast.example.com/2012/08/21/podcast-entry/')
    ->media($mediaitem)
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
    <item xmlns:media="http://search.yahoo.com/mrss">
      <title>Some Media RSS Entry</title>
      <link>http://podcast.example.com/2012/08/21/podcast-entry/</link>
      <description>&lt;div&gt;Podcast body&lt;/div&gt;</description>
      <media:content xmlns:media="http://search.yahoo.com/mrss" url="https://www.example.com" fileSize="5020281" type="audio/mpeg" medium="audio" expression="full" width="1920" height="1080" bitrate="2500" framerate="25" samplingrate="44.1" channels="2" lang="en"/>
      <media:title xmlns:media="http://search.yahoo.com/mrss" type="plain">Oh my wonderful RSS</media:title>
      <media:description xmlns:media="http://search.yahoo.com/mrss">a wonderful song</media:description>
      <media:thumbnail xmlns:media="http://search.yahoo.com/mrss" url="https://example.com/image.jpg" width="900" height="600"/>
      <media:player xmlns:media="http://search.yahoo.com/mrss" url="https://example.com" width="1920" height="1080"/>
      <media:keywords xmlns:media="http://search.yahoo.com/mrss">rock,blues</media:keywords>
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
