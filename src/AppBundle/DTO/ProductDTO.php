<?php

declare(strict_types = 1);

namespace AppBundle\DTO;

/**
 * Class ProductDTO
 * @package AppBundle\DTO
 */
class ProductDTO
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $amount;

    /**
     * ProductDTO constructor.
     * @param int $id
     * @param string $name
     * @param int $amount
     */
    public function __construct(int $id = 0, string $name = '', int $amount = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getId(): int
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

    /**
     * @return int
     */
    public function getAmount(): int
    {
        return $this->amount;
    }

}