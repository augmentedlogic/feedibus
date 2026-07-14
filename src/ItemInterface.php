<?php

namespace com\augmentedlogic\feedibus;

/**
 * Interface ItemInterface
 */
interface ItemInterface
{
    /**
     * Set item title
     * @param string $title
     * @return $this
     */
    public function title(string $title);

    /**
     * Set item URL
     * @param string $url
     * @return $this
     */
    public function url(string $url);

    /**
     * Set item description
     * @param string $description
     * @return $this
     */
    public function description(string $description);

    /**
     * Set content:encoded
     * @param string $content
     * @return $this
     */
    public function contentEncoded(string $content);

    /**
     * Set item category
     * @param string $name Category name
     * @param string $domain Category URL
     * @return $this
     */
    public function category(string $name, ?string $domain = null);

    /**
     * Set GUID
     * @param string $guid
     * @param bool $isPermalink
     * @return $this
     */
    public function guid(string $guid, bool $isPermalink = false);

    /**
     * Set published date
     * @param int $pubDate Unix timestamp
     * @return $this
     */
    public function pubDate(string $pubDate);

    /**
     * Set enclosure
     * @param string $url Url to media file
     * @param int $length Length in bytes of the media file
     * @param string $type Media type, default is audio/mpeg
     * @return $this
     */
    public function enclosure(string $url, int $length = 0, string $type = 'audio/mpeg');

    /**
     * Set the author
     * @param string $author Email of item author
     * @return $this
     */
    public function author(string $author);

    /**
     * Set the source
     * @param string $source
     * @return $this
     */
    public function source(string $source);

    /**
     * Append item to the channel
     * @return $this
     */
    public function appendTo(ChannelInterface $channel);

    /**
     * Return XML object
     */
    public function asXML();
}
