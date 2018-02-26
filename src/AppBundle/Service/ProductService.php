<?php

namespace AppBundle\Service;


use AppBundle\DTO\ProductDTOCollection;
use AppBundle\DTO\ProductDTOFactory;
use AppBundle\Exception\ProductsApiException;
use AppBundle\Query\SearchQuery;
use Curl\Curl;

/**
 * Class ClientService
 * @package AppBundle\Service
 */
class ProductService
{
    private const STORAGE_URL = 'http://storage/app_dev.php/product';
    /**
     * @var Curl
     */
    private $curl;

    /**
     * ClientService constructor.
     * @param Curl $curl
     * @throws \ErrorException
     */
    public function __construct(?Curl $curl = null)
    {
        $this->curl = $curl ?? new Curl();
    }

    /**
     * @param SearchQuery $searchQuery
     * @return ProductDTOCollection
     * @throws ProductsApiException
     */
    public function getProducts(SearchQuery $searchQuery) : ProductDTOCollection
    {
        $this->curl->get(
            self::STORAGE_URL,
            [
                'format' => 'json',
                'search' => $searchQuery->getSearchFor(),
                'page' => $searchQuery->getPage(),
                'perPage' => $searchQuery->getPerPage(),
                'order' => $searchQuery->getOrder()
            ]
        );

        if ( $this->curl->error || '' === $this->curl->response ) {
            $this->curl->close();
            throw new ProductsApiException(
                'Products api error.',
                ProductsApiException::PRODUCTS_API_EXCEPTION_CODE
            );
        }
        $productsRawData = json_decode($this->curl->response);
        $productDTOCollection = ProductDTOFactory::createProductDTOCollectionFromRawData(
            $productsRawData
        );

        $this->curl->response = '';

        $this->curl->close();

        return $productDTOCollection;
    }
}