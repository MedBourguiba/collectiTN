<?php

namespace App\Form;
use App\Type\Enum\UserRoleEnum;
use App\Type\UserRoleEnumType;
use App\Entity\Utilisateur;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UtilisateurType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('prenom')
            ->add('email')
             ->add('roles', ChoiceType::class, [
                'label' => 'User role',
                'choices' => array_combine(UserRoleEnum::toArray2(), UserRoleEnum::toArray2()),
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('telephone')
            ->add('datenaiss')

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Utilisateur::class,
        ]);
    }
}
