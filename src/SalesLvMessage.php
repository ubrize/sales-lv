<?php

namespace Ubrize\SalesLv;

class SalesLvMessage
{
    /**
     * The message content.
     *
     * @var string
     */
    public $content = '';

    /**
     * Create a new message instance.
     *
     * @param string $content
     *
     * @return static
     */
    public static function create($content = '')
    {
        return new static($content);
    }

    /**
     * @param string $content
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /**
     * Set the message content.
     *
     * @param string $content
     *
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }
}
