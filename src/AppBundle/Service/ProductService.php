<?php

namespace AppBundle\Service;


use AppBundle\Command\ProductCommand;
use AppBundle\DTO\ProductDTO;
use AppBundle\DTO\ProductDTOCollection;
use AppBundle\DTO\ProductDTOFactory;
use AppBundle\Exception\ProductsApiException;
use AppBundle\Query\GetProductQuery;
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

    /**
     * @param GetProductQuery $productQuery
     * @return ProductDTO
     * @throws ProductsApiException
     */
    public function getProduct(GetProductQuery $productQuery): ProductDTO
    {
        $this->curl->get(self::STORAGE_URL . '/' . $productQuery->getProductId(), []);

        if ($this->curl->error || '' === $this->curl->response) {
            $this->curl->close();
            throw new ProductsApiException(
                'Products api error.',
                ProductsApiException::PRODUCTS_API_EXCEPTION_CODE
            );
        }

        $productRawData = json_decode($this->curl->response);

        return ProductDTOFactory::createProductDTOFromRawData($productRawData);
    }

    /**
     * @param ProductCommand $productCommand
     * @return void
     * @throws ProductsApiException
     */
    public function addProduct(ProductCommand $productCommand) : void
    {
        $this->curl->post(
            self::STORAGE_URL,
            [
                'name' => $productCommand->getName(),
                'amount' => $productCommand->getAmount()
            ]
        );

        if ($this->curl->error) {
            $this->curl->close();
            throw new ProductsApiException(
                'Products api error.',
                ProductsApiException::PRODUCTS_API_EXCEPTION_CODE
            );
        }
    }

    /**
     * @param ProductCommand $productCommand
     * @return void
     * @throws ProductsApiException
     */
    public function updateProduct(ProductCommand $productCommand) : void
    {
        $this->curl->patch(
            self::STORAGE_URL . '/' . $productCommand->getId(),
            [
                'name' => $productCommand->getName(),
                'amount' => $productCommand->getAmount()
            ],
            true
        );

        if ($this->curl->error) {
            $this->curl->close();
            throw new ProductsApiException(
                'Products api error.',
                ProductsApiException::PRODUCTS_API_EXCEPTION_CODE
            );
        }
    }

    /**
     * @param ProductCommand $productCommand
     * @throws ProductsApiException
     */
    public function deleteProduct(ProductCommand $productCommand) : void
    {
        $this->curl->delete(
              self::STORAGE_URL . '/' . $productCommand->getId(),
              []
        );

        if ($this->curl->error) {
            $this->curl->close();
            throw new ProductsApiException(
                'Products api error.',
                ProductsApiException::PRODUCTS_API_EXCEPTION_CODE
            );
        }
    }


}