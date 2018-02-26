<?php

declare(strict_types = 1);

namespace AppBundle\Exception;

/**
 * Class ProductsNotFoundException
 * @package AppBundle\Exception
 */
class ProductsApiException extends \Exception
{
    public const PRODUCTS_API_EXCEPTION_CODE = 1000;
}