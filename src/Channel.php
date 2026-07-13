<?php

namespace com\augmentedlogic\feedibus;

/**
 * Class Channel
 */
class Channel implements ChannelInterface
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var string
     */
    protected $feedUrl;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var string
     */
    protected $language;

    /**
     * @var string
     */
    protected $copyright;

    /**
     * @var int
     */
    protected $pubDate;

    /**
     * @var int
     */
    protected $lastBuildDate;

    /**
     * @var int
     */
    protected $ttl;

    /**
     * @var string[]
     */
    protected $pubsubhubbub;

    /**
     * @var string
     */
    protected $imageUrl = null;

    /**
     * @var string
     */
    protected $imageTitle = null;

    /**
     * @var string
     */
    protected $imageLink = null;

    /**
     * @var ItemInterface[]
     */
    protected $items = [];

    /**
     * Set channel title
     * @param string $title
     * @return $this
     */
    public function title($title): Channel
    {
        $this->title = $title;
        return $this;
    }

    /**
     * Set channel URL
     * @param string $url
     * @return $this
     */
    public function url($url) : Channel
    {
        $this->url = $url;
        return $this;
    }

    /**
     * Set URL of this feed
     * @param string $url
     * @return $this;
     */
    public function feedUrl($url)
    {
        $this->feedUrl = $url;
        return $this;
    }

    /**
     * Set channel description
     * @param string $description
     * @return $this
     */
    public function description($description) : Channel
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Set ISO639 language code
     *
     * The language the channel is written in. This allows aggregators to group all
     * Italian language sites, for example, on a single page. A list of allowable
     * values for this element, as provided by Netscape, is here. You may also use
     * values defined by the W3C.
     *
     * @param string $language
     * @return $this
     */
    public function language($language): Channel
    {
        $this->language = $language;
        return $this;
    }

    /**
     * Set channel copyright
     * @param string $copyright
     * @return $this
     */
    public function copyright($copyright): Channel
    {
        $this->copyright = $copyright;
        return $this;
    }

    /**
     * Set channel published date
     * @param int $pubDate Unix timestamp
     * @return $this
     */
    public function pubDate($pubDate): Channel
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    /**
     * Set channel last build date
     * @param int $lastBuildDate Unix timestamp
     * @return $this
     */
    public function lastBuildDate($lastBuildDate): Channel
    {
        $this->lastBuildDate = $lastBuildDate;
        return $this;
    }

    /**
     * Set channel ttl (minutes)
     * @param int $ttl
     * @return $this
     */
    public function ttl($ttl): Channel
    {
        $this->ttl = $ttl;
        return $this;
    }

    /**
     * Enable PubSubHubbub discovery
     * @param string $feedUrl
     * @param string $hubUrl
     * @return $this
     */
    public function pubsubhubbub($feedUrl, $hubUrl): Channel
    {
        $this->pubsubhubbub = [
            'feedUrl' => $feedUrl,
            'hubUrl' => $hubUrl,
        ];
        return $this;
    }

    /**
     * Add item object
     * @param ItemInterface $item
     * @return $this
     */
    public function addItem(ItemInterface $item): Channel
    {
        $this->items[] = $item;
        return $this;
    }

    /**
     * Append to feed
     * @param FeedInterface $feed
     * @return $this
     */
    public function appendTo(FeedInterface $feed): Channel
    {
        $feed->addChannel($this);
        return $this;
    }

    public function image(ChannelImage $channel_image): Channel
    {
        $this->imageUrl = $channel_image->getUrl();
        $this->imageTitle = $channel_image->getTitle();
        $this->imageLink = $channel_image->getLink();
        return $this;
    }

    /**
     * Return XML object
     * @return SimpleXMLElement
     */
    public function asXML(): SimpleXMLElement
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><channel></channel>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);
        $xml->addChild('title', $this->title);
        $xml->addChild('link', $this->url);
        $xml->addChild('description', $this->description);

        if ($this->feedUrl !== null) {
            $link = $xml->addChild('atom:link', '', 'http://www.w3.org/2005/Atom');
            $link->addAttribute('href', $this->feedUrl);
            $link->addAttribute('type', 'application/rss+xml');
            $link->addAttribute('rel', 'self');
        }

        if ($this->language !== null) {
            $xml->addChild('language', $this->language);
        }

        if ($this->copyright !== null) {
            $xml->addChild('copyright', $this->copyright);
        }

        if ($this->pubDate !== null) {
            $xml->addChild('pubDate', date(DATE_RSS, $this->pubDate));
        }

        if ($this->lastBuildDate !== null) {
            $xml->addChild('lastBuildDate', date(DATE_RSS, $this->lastBuildDate));
        }

        if ($this->ttl !== null) {
            $xml->addChild('ttl', $this->ttl);
        }

        if ($this->pubsubhubbub !== null) {
            $feedUrl = $xml->addChild('xmlns:atom:link');
            $feedUrl->addAttribute('rel', 'self');
            $feedUrl->addAttribute('href', $this->pubsubhubbub['feedUrl']);
            $feedUrl->addAttribute('type', 'application/rss+xml');

            $hubUrl = $xml->addChild('xmlns:atom:link');
            $hubUrl->addAttribute('rel', 'hub');
            $hubUrl->addAttribute('href', $this->pubsubhubbub['hubUrl']);
        }

        if ($this->imageUrl !== null || $this->imageTitle !== null || $this->imageLink !== null) {
            $imagexml = $xml->addChild('image');
            if ($this->imageUrl !== null) {
                $imagexml->addChild('url', $this->imageUrl);
            }
            if ($this->imageTitle !== null) {
                $imagexml->addChild('title', $this->imageTitle);
            }
            if ($this->imageLink !== null) {
                $imagexml->addChild('link', $this->imageLink);
            }
        }

        foreach ($this->items as $item) {
            $toDom = dom_import_simplexml($xml);
            $fromDom = dom_import_simplexml($item->asXML());
            $toDom->appendChild($toDom->ownerDocument->importNode($fromDom, true));
        }

        return $xml;
    }
}
