<?php

declare(strict_types = 1);

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Tests\Fixtures\Type;

/**
 * Class SearchProductType
 * @package AppBundle\Form
 */
class ProductType extends AbstractType
{
    public const ID_KEY = 'id';
    public const NAME_KEY = 'name';
    public const AMOUNT_KEY = 'amount';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $nameFieldOptions = ['label' => 'Product name: '];
        $amountFieldOptions = ['label' => 'Product amount: '];
        $idFieldOptions = [];

        if (array_key_exists('data', $options))
        {
            if (array_key_exists('id', $options['data'])) {
                $idFieldOptions = ['data' => $options['data']['id']];
            }
            if (array_key_exists('name', $options['data'])) {
                $nameFieldOptions = ['label' => 'Product name: ', 'data' => $options['data']['name']];
            }
            if (array_key_exists('amount', $options['data'])) {
                $amountFieldOptions = ['label' => 'Product amount: ', 'data' => $options['data']['amount']];
            }
        }
        $builder
            ->add(self::NAME_KEY, TextType::class, $nameFieldOptions)
            ->add(self::AMOUNT_KEY, TextType::class, $amountFieldOptions)
            ->add(self::ID_KEY, HiddenType::class, $idFieldOptions)
            ->add('Add/Update product', SubmitType::class);
    }

}