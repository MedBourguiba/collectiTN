<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class StarRatingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->add('star_1', ButtonType::class, [
            'label' => '★',
            'attr' => [
                'class' => 'star-rating',
                'data-value' => 1,
            ],
        ]);

        $builder->add('star_2', ButtonType::class, [
            'label' => '★',
            'attr' => [
                'class' => 'star-rating',
                'data-value' => 2,
            ],
        ]);

        $builder->add('star_3', ButtonType::class, [
            'label' => '★',
            'attr' => [
                'class' => 'star-rating',
                'data-value' => 3,
            ],
        ]);

        $builder->add('star_4', ButtonType::class, [
            'label' => '★',
            'attr' => [
                'class' => 'star-rating',
                'data-value' => 4,
            ],
        ]);

        $builder->add('star_5', ButtonType::class, [
            'label' => '★',
            'attr' => [
                'class' => 'star-rating',
                'data-value' => 5,
            ],
        ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'required' => true,
            'choice_translation_domain' => 'my_translation_domain',
        ]);
    }

    public function getParent(): string
    {
        return \Symfony\Component\Form\Extension\Core\Type\FormType::class;
    }
}
