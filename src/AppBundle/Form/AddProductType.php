<?php

declare(strict_types = 1);

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

/**
 * Class SearchProductType
 * @package AppBundle\Form
 */
class AddProductType extends AbstractType
{
    public const NAME_KEY = 'name';
    public const AMOUNT_KEY = 'amount';

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options) : void
    {
        $builder
            ->add(self::NAME_KEY, TextType::class, [
                    'label' => 'Product name: ',
            ])
            ->add(self::AMOUNT_KEY, TextType::class, [
                    'label' => 'Product amount: ',
            ])
            ->add('Add product', SubmitType::class);
    }

}