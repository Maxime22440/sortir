<?php

namespace App\Form\modele;

use App\Entity\Campus;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SortiesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $filter, array $options): void
    {
        $filter
            ->add('campus', EntityType::class)
            ->add('recherche', TextType::class)
            ->add('Firstdate', DateType::class)
            ->add('SecondDate', DateType::class)
            ->add('sortieOrganisateur', CheckboxType::class)
            ->add('sortieInscrit',CheckboxType::class)
            ->add('sortieNonInscrit', CheckboxType::class)
            ->add('sortiesPasses', CheckboxType::class)
            ->add('submit',SubmitType::class)

        ;



    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([

        ]);
    }
}
