<?php

declare(strict_types = 1);

namespace AppBundle\Command;

/**
 * Class ProductCommand
 * @package AppBundle\Command
 */
abstract class ProductCommand
{
    public const NULL_ID = null;
    /**
     * @var int $id
     */
    private $id;
    /**
     * @var string $name
     */
    private $name;
    /**
     * @var int $amount
     */
    private $amount;

    /**
     * ProductCommand constructor.
     * @param int $id
     * @param string $name
     * @param int $amount
     */
    public function __construct(?int $id = self::NULL_ID, string $name = '', int $amount = 0)
    {
        $this->id = $id;
        $this->name = $name;
        $this->amount = $amount;
    }

    /**
     * @return int
     */
    public function getId(): ?int
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