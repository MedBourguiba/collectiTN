<?php

namespace App\Form;

use App\Entity\Item;
use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\GreaterThan;
use Symfony\Component\Validator\Constraints\LessThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Length;


class ItemType extends AbstractType
{
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category', EntityType::class, [
              'class' => Category::class,
              'choice_label' => 'name'
            ])
            ->add('name', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length(['min' => 2, 'max' => 255]),
                    new Callback(function ($value, ExecutionContextInterface $context) {
                        if (!ctype_alpha(str_replace(' ', '', $value))) {
                            $context->buildViolation('le nom doit etre seulement en lettres .')
                                ->addViolation();
                        }
                    })
                ]
            ])
            ->add('description', TextType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Length([
                        'min' => 10, 'max' => 1000,'minMessage' => 'La description doit contenir au moins {{ limit }} caractères.',
                        'maxMessage' => 'La description ne peut pas contenir plus de {{ limit }} caractères.',]),
                    new Callback(function ($value, ExecutionContextInterface $context) {
                        if (!ctype_alpha(str_replace(' ', '', $value))) {
                            $context->buildViolation('la description doit en lettres seulement ')
                                ->addViolation();
                        }
                    })
                ]
            ])
            ->add('start_time', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de début ne peut pas être vide.',
                    ]),
                    new Type([
                        'type' => '\DateTime',
                        'message' => 'La date de début doit être une date valide.',
                    ]),
                    new GreaterThanOrEqual([
                        'value' => 'today',
                        'message' => 'La date de début doit être supérieure ou égale à aujourd\'hui.',
                    ]),
                    new LessThanOrEqual([
                        'propertyPath' => 'parent.all[end_time].data',
                        'message' => 'La date de début doit être inférieure ou égale à la date de fin.',
                    ]),
                ],
            ])
            ->add('end_time', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'La date de fin ne peut pas être vide.',
                    ]),
                    new Type([
                        'type' => '\DateTime',
                        'message' => 'La date de fin doit être une date valide.',
                    ]),
                    new GreaterThanOrEqual([
                        'propertyPath' => 'parent.all[start_time].data',
                        'message' => 'La date de fin doit être supérieure ou égale à la date de début.',
                    ]),
                ],
            ])
            
            ->add('starting_price', MoneyType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 1, 'max' => PHP_INT_MAX]),
                ]
            ])
            ->add('estimated_price', MoneyType::class, [
                'constraints' => [
                    new NotBlank(),
                    new Range(['min' => 5, 'max' => PHP_INT_MAX]),
                    new Callback(function ($value, ExecutionContextInterface $context) {
                        $form = $context->getRoot();
                        $startingPrice = $form->get('starting_price')->getData();
    
                        if ($value < (5 * $startingPrice)) {
                            $context->buildViolation('le prix estimé doit etre au minimum 5 fois le prix de départ')
                                ->addViolation();
                        }
                    })
                ]
            ])
           ->add('img', FileType::class, [
            'data_class' => null,
            'constraints' => [
        new NotBlank(),

    ],
  ])

            ->add('submit', SubmitType::class, [
                'label' => 'Save',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
