<?php
namespace OpenEDU\Course\Interfaces\DTO;

class CourseDTO
{
    /**
     * @var string
     */
    protected $title;

    /**
     * @var string
     */
    protected $description;

    /**
     * @var TableOfContentDTO[]
     */
    protected $tableOfContents;

    public function __construct($title, $description, $tableOfContents)
    {
        $this->title = $title;
        $this->description = $description;
        $this->tableOfContents = $tableOfContents;
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

    /**
     * @return string
     */
    public function description(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }


    /**
     * @return TableOfContentDTO[]
     */
    public function tableOfContents(): array
    {
        return $this->tableOfContents;
    }

    /**
     * @param TableOfContentDTO[] $tableOfContents
     */
    public function setTableOfContents(array $tableOfContents): void
    {
        $this->tableOfContents = $tableOfContents;
    }


}