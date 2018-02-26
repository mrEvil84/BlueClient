<?php
declare(strict_types = 1);

namespace AppBundle\Query;

/**
 * Class getProductQuery
 * @package AppBundle\Query
 */
class GetProductQuery
{
    public const NULL_PRODUCT_ID = 0;
    /**
     * @var int $productId
     */
    private $productId;

    /**
     * getProductQuery constructor.
     * @param int $productId
     */
    public function __construct(int $productId = self::NULL_PRODUCT_ID)
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

}