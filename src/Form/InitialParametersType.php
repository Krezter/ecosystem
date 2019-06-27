<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class InitialParametersType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('size', NumberType::class, [
                'label' => 'Размер карты'
            ])
            ->add('time', NumberType::class, [
                'label' => 'Время наблюдения'
            ])
            ->add('csv', FileType::class, [
                'label' => 'CSV файл',
                'required' => false
            ])
            ->add('status', ChoiceType::class, [
                'label' => ' ',
                'choices' => [
                    'Сохранить в БД' => true,
                    'Сохранить в сессии' => false
                ],
                'expanded' => true
            ])
            ->add('start', SubmitType::class, [
                'label' => 'Начать с начала'
            ])
            ->add('continue', SubmitType::class, [
                'label' => 'Продолжить'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
