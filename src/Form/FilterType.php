<?php

namespace App\Form;

use App\Entity\Campus;
use App\Form\modele\Filter;
use Doctrine\ORM\EntityRepository;
use http\Client\Curl\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {


        $builder
            ->add('campus', EntityType::class,[
                'class'=> Campus::class,
                'choice_label'=>'nom'
            ])
            ->add('recherche', TextType::class,[
                'required' => false
            ])
            ->add('Firstdate', DateType::class)
            ->add('SecondDate', DateType::class)
            ->add('sortieOrganisateur', CheckboxType::class,[
                'required' => false

            ])
            ->add('sortieInscrit',CheckboxType::class,[
                'required' => false
            ])
            ->add('sortieNonInscrit', CheckboxType::class,[
                'required' => false

            ])
            ->add('sortiesPasses', CheckboxType::class,[
                'required' => false
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Filter::class,
        ]);
    }
}
