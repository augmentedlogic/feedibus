<?php

namespace com\augmentedlogic\feedibus;

/**
 * Class Item
 */
class Item implements ItemInterface
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
    protected $description;

    /**
     * @var string
     */
    protected $contentEncoded;

    /**
     * @var array
     */
    protected $categories = [];

    /**
     * @var string
     */
    protected $guid;

    /**
     * @var bool
     */
    protected $isPermalink;

    /**
     * @var int
     */
    protected $pubDate;

    /**
     * @var array
     */
    protected $enclosure;

    /**
     * @var string
     */
    protected $author;

    /**
     * @var string
     */
    protected $creator;

    /**
     * @var source
     */
    protected $source;

    /**
     * @var MediaItem
     */
    protected $media;

    protected $preferCdata = false;

    public function title(string $title): Item
    {
        $this->title = $title;
        return $this;
    }

    public function url(string $url): Item
    {
        $this->url = $url;
        return $this;
    }

    public function description(string $description): Item
    {
        $this->description = $description;
        return $this;
    }

    public function contentEncoded(string $content): Item
    {
        $this->contentEncoded = $content;
        return $this;
    }

    public function category(string $name, ?string $domain = null): Item
    {
        $this->categories[] = [$name, $domain];
        return $this;
    }

    public function categories(array $categories): Item
    {
        foreach ($categories as $cat) {
            $domain = null;
            if (is_array($cat) && !empty($cat)) {
                $domain = isset($cat[1]) ? $cat[1] : null;
                $cat = $cat[0];
            }
            $this->category($cat, $domain);
        }
        return $this;
    }

    public function guid(string $guid, bool $isPermalink = false): Item
    {
        $this->guid = $guid;
        $this->isPermalink = $isPermalink;
        return $this;
    }

    public function pubDate(string $pubDate): Item
    {
        $this->pubDate = $pubDate;
        return $this;
    }

    public function enclosure(string $url, int $length = 0, string $type = 'audio/mpeg'): Item
    {
        $this->enclosure = ['url' => $url, 'length' => $length, 'type' => $type];
        return $this;
    }

    public function author(string $author): Item
    {
        $this->author = $author;
        return $this;
    }

    public function creator(string $creator): Item
    {
        $this->creator = $creator;
        return $this;
    }

    public function preferCdata(bool $preferCdata): Item
    {
        $this->preferCdata = (bool) $preferCdata;
        return $this;
    }

    public function source(string $source): Item
    {
        $this->source = (string) $source;
        return $this;
    }

    public function media(MediaItem $media): Item
    {
        $this->media = $media;
        return $this;
    }

    public function appendTo(ChannelInterface $channel): Item
    {
        $channel->addItem($this);
        return $this;
    }

    public function asXML(): SimpleXMlElement
    {
        $xml = new SimpleXMLElement('<?xml version="1.0" encoding="UTF-8" ?><item></item>', LIBXML_NOERROR | LIBXML_ERR_NONE | LIBXML_ERR_FATAL);

        if ($this->title) {
            if ($this->preferCdata) {
                $xml->addCdataChild('title', $this->title);
            } else {
                $xml->addChild('title', $this->title);
            }
        }

        if ($this->url) {
            $xml->addChild('link', $this->url);
        }

        // At least one of <title> or <description> must be present
        if ($this->description || !$this->title) {
            if ($this->preferCdata) {
                $xml->addCdataChild('description', $this->description);
            } else {
                $xml->addChild('description', $this->description);
            }
        }

        if ($this->contentEncoded) {
            $xml->addCdataChild('xmlns:content:encoded', $this->contentEncoded);
        }

        foreach ($this->categories as $category) {
            $element = $xml->addChild('category', $category[0]);

            if (isset($category[1])) {
                $element->addAttribute('domain', $category[1]);
            }
        }

        if ($this->guid) {
            $guid = $xml->addChild('guid', $this->guid);

            if ($this->isPermalink === false) {
                $guid->addAttribute('isPermaLink', 'false');
            }
        }

        if ($this->pubDate !== null) {
            $xml->addChild('pubDate', date(DATE_RSS, $this->pubDate));
        }

        if (is_array($this->enclosure) && (count($this->enclosure) == 3)) {
            $element = $xml->addChild('enclosure');
            $element->addAttribute('url', $this->enclosure['url']);
            $element->addAttribute('type', $this->enclosure['type']);

            if ($this->enclosure['length']) {
                $element->addAttribute('length', $this->enclosure['length']);
            }
        }

        if (!empty($this->author)) {
            $xml->addChild('author', $this->author);
        }

        if (!empty($this->creator)) {
            $xml->addChild('dc:creator', $this->creator, 'http://purl.org/dc/elements/1.1/');
        }

        if (!empty($this->source)) {
            $xml->addChild('source', $this->source);
        }

        if (!empty($this->media)) {
            // url, fileSize, type, medium, duration, expression
            $mediacontent = $xml->addChild('media:content', '', 'http://search.yahoo.com/mrss');
            if ($this->media->getUrl() !== null) {
                $mediacontent->addAttribute('url', $this->media->getUrl());

                if ($this->media->getFilesize() !== null) {
                    $mediacontent->addAttribute('fileSize', $this->media->getFilesize());
                }

                if ($this->media->getFiletype() !== null) {
                    $mediacontent->addAttribute('type', $this->media->getFiletype());
                }

                if ($this->media->getMedium() !== null) {
                    $mediacontent->addAttribute('medium', $this->media->getMedium());
                }

                if ($this->media->getDuration() !== null) {
                    $mediacontent->addAttribute('duration', $this->media->getDuration());
                }

                if ($this->media->getExpression() !== null) {
                    $mediacontent->addAttribute('expression', $this->media->getExpression());
                }

                if ($this->media->getWidth() !== null) {
                    $mediacontent->addAttribute('width', $this->media->getWidth());
                }

                if ($this->media->getHeight() !== null) {
                    $mediacontent->addAttribute('height', $this->media->getHeight());
                }

                if ($this->media->getBitrate() != null) {
                    $mediacontent->addAttribute('bitrate', $this->media->getBitrate());
                }

                if ($this->media->getFramerate() != null) {
                    $mediacontent->addAttribute('framerate', $this->media->getFramerate());
                }

                if ($this->media->getSamplingrate() != null) {
                    $mediacontent->addAttribute('samplingrate', $this->media->getSamplingrate());
                }

                if ($this->media->getChannels() != null) {
                    $mediacontent->addAttribute('channels', $this->media->getChannels());
                }

                if ($this->media->getLang() != null) {
                    $mediacontent->addAttribute('lang', $this->media->getLang());
                }
            }

            // media:title
            if ($this->media->getTitle() !== null) {
                $mediatitle = $xml->addChild('media:title', $this->media->getTitle(), 'http://search.yahoo.com/mrss');
                $mediatitle->addAttribute('type', $this->media->getTitleType());
            }

            // media:description
            if ($this->media->getDescription() !== null) {
                $mediadescription = $xml->addChild('media:description', $this->media->getDescription(), 'http://search.yahoo.com/mrss');
            }

            // media:thumbnail
            if ($this->media->getThumbnail() !== null) {
                $mediathumbnail = $xml->addChild('media:thumbnail', '', 'http://search.yahoo.com/mrss');
                $mediathumbnail->addAttribute('url', $this->media->getThumbnail());

                if ($this->media->getThumbnailWidth() !== null) {
                    $mediathumbnail->addAttribute('width', $this->media->getThumbnailWidth());
                }
                if ($this->media->getThumbnailHeight() !== null) {
                    $mediathumbnail->addAttribute('height', $this->media->getThumbnailHeight());
                }
            }

            //  media:player
            if ($this->media->getPlayerUrl() !== null) {
                $mediaplayer = $xml->addChild('media:player', '', 'http://search.yahoo.com/mrss');
                $mediaplayer->addAttribute('url', $this->media->getPlayerUrl());

                if ($this->media->getPlayerWidth() !== null) {
                    $mediaplayer->addAttribute('width', $this->media->getPlayerWidth());
                }
                if ($this->media->getPlayerHeight() !== null) {
                    $mediaplayer->addAttribute('height', $this->media->getPlayerHeight());
                }
            }

            // media:keywords
            if ($this->media->getKeywords() !== null) {
                $mediacategory = $xml->addChild('media:keywords', implode(',', $this->media->getKeywords()), 'http://search.yahoo.com/mrss');
            }

            if ($this->media->getHash() !== null) {
                $mediahash = $xml->addChild('media:hash', $this->media->getHash(), 'http://search.yahoo.com/mrss');
                $mediahash->addAttribute('algo', $this->media->getAlgo());
            }

        }

        return $xml;
    }
}
