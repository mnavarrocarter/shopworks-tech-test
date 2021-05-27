<?php


namespace Shopworks\Model;

use Ramsey\Uuid\UuidInterface;

/**
 * Class Staff
 * @package Shopworks
 */
class Staff
{
    private UuidInterface $id;
    private string $name;

    /**
     * Staff constructor.
     * @param UuidInterface $id
     * @param string $name
     */
    public function __construct(UuidInterface $id, string $name)
    {
        $this->id = $id;
        $this->name = $name;
    }

    /**
     * @return UuidInterface
     */
    public function getId(): UuidInterface
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}