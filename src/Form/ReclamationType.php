<?php

namespace App\Form;

use App\Entity\Reclamation;
use App\Entity\Item;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Security\Core\Security;
use Doctrine\ORM\EntityManagerInterface;

class ReclamationType extends AbstractType
{
    private $security;
    private $entityManager;

    public function __construct(Security $security, EntityManagerInterface $entityManager)
    {
        $this->security = $security;
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('email')
            ->add('sujet')
            ->add('message');

        $builder->addEventListener(FormEvents::SUBMIT, function (FormEvent $event) {
            $reclamation = $event->getData();

            // Set the date of the reclamation to the current date and time
            $reclamation->setDateReclamation(new \DateTime());

            // Get the user from the security context
            $user = $this->security->getUser();
            $reclamation->setUser($user);

            // Set the item to a default value or get it from the user input
            // Replace "YourDefaultValue" with the default value for the item
            $reclamation->setItem($this->entityManager->getRepository(Item::class)->findOneBy(['name' => 'YourDefaultValue']));

            $event->setData($reclamation);
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reclamation::class,
        ]);
    }
}
