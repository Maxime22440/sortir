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
                'choice_label'=>'nom',
                'label' => false
            ])
            ->add('recherche', TextType::class,[
                'required' => false,
                'label' => false
            ])
            ->add('Firstdate', DateType::class,[
                'label' => 'Entre',
                'widget' => 'single_text',
                'label' => false
            ])
            ->add('SecondDate', DateType::class,[
                'label' => 'Et',
                'widget' => 'single_text',
                'label' => false
            ])
            ->add('sortieOrganisateur', CheckboxType::class,[
                'label' => 'Sorties dont je suis l organisateur/trice',
                'required' => false,
                'label' => false

            ])
            ->add('sortieInscrit',CheckboxType::class,[
                'label' => 'Sorties auxquelles je suis inscrit/e',
                'required' => false,
                'label' => false
            ])
            ->add('sortieNonInscrit', CheckboxType::class,[
                'label' => 'Sorties auxquelles je ne suis pas inscrit/e',
                'required' => false,
                'label' => false

            ])
            ->add('sortiesPasses', CheckboxType::class,[
                'label' => 'Sorties passées',
                'required' => false,
                'label' => false
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
