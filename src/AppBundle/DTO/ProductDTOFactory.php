<?php

declare(strict_types = 1);

namespace AppBundle\DTO;

/**
 * Class ProductDTOFactory
 * @package AppBundle\DTO
 */
class ProductDTOFactory
{
    private const FIRST_ELEMENT = 0;

    public static function createProductDTOCollectionFromRawData(array $rawData = []) : ProductDTOCollection
    {
        $productsDtoCollection = new ProductDTOCollection();
        foreach ($rawData as $item) {
            $productsDtoCollection->add(new ProductDTO((int)$item->id, (string)$item->name, (int)$item->amount));
        }

        return $productsDtoCollection;
    }

    /**
     * @param array $rawData
     * @return ProductDTO
     */
    public static function createProductDTOFromRawData(array $rawData = []) : ProductDTO
    {
        $data = $rawData[self::FIRST_ELEMENT];
        return new ProductDTO((int)$data->id, (string)$data->name, (int)$data->amount);
    }

}