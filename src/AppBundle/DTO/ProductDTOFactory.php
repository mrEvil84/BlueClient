<?php

declare(strict_types = 1);

namespace AppBundle\DTO;

/**
 * Class ProductDTOFactory
 * @package AppBundle\DTO
 */
class ProductDTOFactory
{
    public static function createProductDTOCollectionFromRawData(array $rawData = []) : ProductDTOCollection
    {
        $productsDtoCollection = new ProductDTOCollection();
        foreach ($rawData as $item) {
            $productsDtoCollection->add(new ProductDTO((int)$item->id, (string)$item->name, (int)$item->amount));
        }

        return $productsDtoCollection;
    }

}