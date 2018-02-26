<?php

declare(strict_types = 1);

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class SearchProductType
 * @package AppBundle\Form
 */
class SearchProductType extends AbstractType
{
    public const SEARCH_FOR_KEY = 'SearchFor';
    public const SORT_ORDER_KEY = 'SortOrder';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add(self::SEARCH_FOR_KEY, ChoiceType::class, [
                    'label' => 'Search for products: ',
                    'choices' => [
                        'Existing products' => 'existing',
                        'Non existing products' => 'non_existing',
                        'Max 5 products in store' => 'min_amount'
                    ]
            ])
            ->add(self::SORT_ORDER_KEY, ChoiceType::class, [
                'label' => 'Name product sort order: ',
                'choices' => [
                    'Asc' => 'ASC',
                    'Desc' => 'DESC'
                ]
            ])
            ->add('Search for products', SubmitType::class);

    }

}