<?php

namespace com\augmentedlogic\feedit;

/**
 * Class ChannelImage
 */
class ChannelImage
{

    private ?string $url = null;
    private ?string $title = null;
    private ?string $link = null;

    public function setUrl(string $url): void
    {
       $this->url = $url;
    }

    public function setTitle(string $title): void
    {
       $this->title = $title;
    }

    public function setLink(string $link): void
    {
       $this->link = $link;
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
