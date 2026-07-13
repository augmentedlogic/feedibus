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
    private ?string $mediatype = null;
    // <media:title>
    private ?string $title = null;
    // <media:description>
    private ?string $description = null;
    // <media:thumbnail>
    private ?string $thumbnail = null;
    private ?int $thumbnail_width = null;
    private ?int $thumbnail_height = null;
    private ?string $keywords = null;
    private ?string $category = null;
    private ?string $playerUrl = null;
    private ?int $playerWith = null;
    private ?int $playerHeight = null;

    public function url(string $url): MediaItem
    {
        $this->url = $url;
        return $this;
    }

    public function title(string $title): MediaItem
    {
        $this->title = $title;
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

    // getters

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getTitle(): ?string
    {
        return $this->title;
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

    public function getWidth(): ?int
    {
        return $this->width;
    }

    public function getHeight(): ?int
    {
        return $this->height;
    }
}
