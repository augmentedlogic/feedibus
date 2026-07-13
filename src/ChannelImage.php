<?php

namespace com\augmentedlogic\feedibus;

/**
 * Class ChannelImage
 */
class ChannelImage
{
    private ?string $url = null;
    private ?string $title = null;
    private ?string $link = null;

    public function url(string $url): ChannelImage
    {
        $this->url = $url;
        return $this;
    }

    public function title(string $title): ChannelImage
    {
        $this->title = $title;
        return $this;
    }

    public function link(string $link): ChannelImage
    {
        $this->link = $link;
        return $this;
    }

    public function getUrl()
    {
        return $this->url;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getLink()
    {
        return $this->link;
    }
}
