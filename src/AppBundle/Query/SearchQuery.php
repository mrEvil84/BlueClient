<?php

declare(strict_types = 1);

namespace AppBundle\Query;

/**
 * Class SearchQuery
 */
class SearchQuery
{
    public const SEARCH_FOR_EXISTING = 'existing';
    public const SEARCH_FOR_NON_EXISTING = 'non_existing';
    public const SEARCH_FOR_MIN_AMOUNT = 'min_amount';

    /**
     * @var string $searchFor existing|non_existing|min_amount
     */
    private $searchFor;
    /**
     * @var string $order ASC|DESC
     */
    private $order;
    /**
     * @var int $page
     */
    private $page;
    /**
     * @var int $perPage
     */
    private $perPage;

    /**
     * SearchQuery constructor.
     * @param string $searchFor
     * @param string $order
     * @param int $page
     * @param int $perPage
     */
    public function __construct($searchFor = self::SEARCH_FOR_EXISTING, $order = 'ASC', $page = 0, $perPage = 10)
    {
        $this->searchFor = $searchFor;
        $this->order = $order;
        $this->page = $page;
        $this->perPage = $perPage;
    }

    /**
     * @return string
     */
    public function getSearchFor(): string
    {
        return $this->searchFor;
    }

    /**
     * @return string
     */
    public function getOrder(): string
    {
        return $this->order;
    }

    /**
     * @return int
     */
    public function getPage(): int
    {
        return $this->page;
    }

    /**
     * @return int
     */
    public function getPerPage(): int
    {
        return $this->perPage;
    }

}