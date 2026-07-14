<?php

namespace com\augmentedlogic\feedibus;

/**
 * Class MediaItem
 */
class MediaItem
{
    // <media:content>
    private ?string $url = null;
    private ?int $filesize = null;
    private ?string $filetype = null;
    private ?string $medium = null;
    private ?int $duration = null;
    private ?int $width = null;
    private ?int $height = null;
    private ?string $expression = null;  // e.g. "full"
    private ?int $bitrate = null;
    private ?int $framerate = null;
    private ?float $samplingrate = null;  // e.g. 44.1
    private ?int $channels = null;
    private ?string $lang = null;
    // <media:title>
    private ?string $title = null;
    private string $title_type = 'plain';
    // <media:thumbnail>
    private ?string $thumbnail = null;
    private ?int $thumbnail_width = null;
    private ?int $thumbnail_height = null;
    // <media:description>
    private ?string $description = null;
    // <media:keywords>
    private ?array $keywords = null;
    // <media:player>
    private ?string $playerUrl = null;
    private ?int $playerWith = null;
    private ?int $playerHeight = null;
    // <media:hash>
    private ?string $hash = null;
    private string $algo = "md5";

    // NOT YET IMPLEMENTED
    private ?string $category = null;
    // <media:rating>
    private ?string $rating = null;
    // <media:copyright>
    private ?string $copyright = null;
    private ?string $copyright_url = null;

    /**
     * media:content
     */
    public function url(string $url): MediaItem
    {
        $this->url = $url;
        return $this;
    }

    public function filesize(int $filesize): MediaItem
    {
        $this->filesize = $filesize;
        return $this;
    }

    public function filetype(string $filetype): MediaItem
    {
        $this->filetype = $filetype;
        return $this;
    }

    public function medium(string $medium): MediaItem
    {
        $this->medium = $medium;
        return $this;
    }

    public function duration(int $duration): MediaItem
    {
        $this->duration = $duration;
        return $this;
    }

    public function width(int $width): MediaItem
    {
        $this->width = $width;
        return $this;
    }

    public function height(int $height): MediaItem
    {
        $this->height = $height;
        return $this;
    }

    public function bitrate(int $bitrate): MediaItem
    {
        $this->bitrate = $bitrate;
        return $this;
    }

    public function framerate(int $framerate): MediaItem
    {
        $this->framerate = $framerate;
        return $this;
    }

    public function samplingrate(float $samplingrate): MediaItem
    {
        $this->samplingrate = $samplingrate;
        return $this;
    }

    public function channels(int $channels): MediaItem
    {
        $this->channels = $channels;
        return $this;
    }

    public function lang(string $lang): MediaItem
    {
        $this->lang = $lang;
        return $this;
    }

    public function expression(string $expression): MediaItem
    {
        $this->expression = $expression;
        return $this;
    }

    /**
     * <media:title>
     */
    public function title(string $title, ?string $title_type = 'plain'): MediaItem
    {
        // TODO html
        $this->title = $title;
        $this->title_type = $title_type;
        return $this;
    }

    /**
     * <media:thumbnail>
     */
    public function thumbnail(string $thumbnail): MediaItem
    {
        $this->thumbnail = $thumbnail;
        return $this;
    }

    public function thumbnailWidth(int $width): MediaItem
    {
        $this->thumbnail_width = $width;
        return $this;
    }

    public function thumbnailHeight(int $height): MediaItem
    {
        $this->thumbnail_height = $height;
        return $this;
    }

    // <media:description>
    public function description(string $description): MediaItem
    {
        $this->description = $description;
        return $this;
    }

    // <media:keywords>
    public function keywords(array $keywords): MediaItem
    {
        $this->keywords = $keywords;
        return $this;
    }

    // <media:player>
    public function playerUrl(string $url): MediaItem
    {
        $this->playerUrl = $url;
        return $this;
    }

    public function playerWidth(int $width): MediaItem
    {
        $this->playerWidth = $width;
        return $this;
    }

    public function playerHeight(int $height): MediaItem
    {
        $this->playerHeight = $height;
        return $this;
    }

    // <media:hash>
    public function hash(string $hash, string $algo = "md5"): MediaItem
    {
        $this->hash = $hash;
        $this->algo = $algo;
        return $this;
    }

    //
    // getters
    //

    // <media:content>
    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getFiletype(): ?string
    {
        return $this->filetype;
    }

    public function getFilesize(): ?int
    {
        return $this->filesize;
    }

    public function getMedium(): ?string
    {
        return $this->medium;
    }

    public function getDuration(): ?int
    {
        return $this->duration;
    }

    public function getExpression(): ?string
    {
        return $this->expression;
    }

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }

    public function getBitrate(): ?int
    {
        return $this->bitrate;
    }

    public function getFramerate(): ?int
    {
        return $this->framerate;
    }

    public function getSamplingrate(): ?float
    {
        return $this->samplingrate;
    }

    public function getChannels(): ?int
    {
        return $this->channels;
    }

    public function getLang(): ?string
    {
        return $this->lang;
    }

    // <media:title>
    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function getTitleType(): ?string
    {
        return $this->title_type;
    }

    // <media:thumbnail>
    public function getThumbnail(): ?string
    {
        return $this->thumbnail;
    }

    public function getThumbnailWidth(): ?int
    {
        return $this->thumbnail_width;
    }

    public function getThumbnailHeight(): ?int
    {
        return $this->thumbnail_height;
    }

    // <media:description>
    public function getDescription(): ?string
    {
        return $this->description;
    }

    // <media:keywords>
    public function getKeywords(): ?array
    {
        return $this->keywords;
    }

    // <media:player>
    public function getPlayerUrl(): ?string
    {
        return $this->playerUrl;
    }

    public function getPlayerWidth(): ?int
    {
        return $this->playerWidth;
    }

    public function getPlayerHeight(): ?int
    {
        return $this->playerHeight;
    }

    // <media:hash>
    public function getHash(): ?string
    {
        return $this->hash;
    }

    public function getAlgo(): string
    {
        return $this->algo;
    }

}
