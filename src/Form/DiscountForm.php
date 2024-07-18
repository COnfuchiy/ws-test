<?php

namespace App\Form;

use App\Entity\Participant;
use DateTime;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DiscountForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('base_cost', MoneyType::class, [
                'currency' => 'RUB',
                'required' => true,
            ])
            ->add('birthdate', DateType::class, [
                'format' => 'd-m-Y',
                'required' => true,
            ])
            ->add('trip_start_date', DateType::class, [
                'format' => 'd-m-Y',
                'required' => false,
                'empty_data' => new DateTime(),
            ])
            ->add('payment_date', DateType::class, [
                'format' => 'd-m-Y',
                'required' => false,
                'empty_data' => new DateTime(),
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}