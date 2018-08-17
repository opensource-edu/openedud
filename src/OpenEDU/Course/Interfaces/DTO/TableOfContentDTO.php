<?php
namespace OpenEDU\Course\Interfaces\DTO;

class TableOfContentDTO
{
    /**
     * @var string
     */
    private $title;

    public function __construct($title)
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function title(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }


}