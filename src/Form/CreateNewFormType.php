<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateNewFormType extends AbstractType
{












    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut')
            ->add('duree')
            ->add('dateLimiteInscription')
            ->add('nbInscriptionsMax')
            ->add('infosSortie')

            ->add('lieu',EntityType::class,[
                'class' => Lieu::class,
                'query_builder'=>function (EntityRepository $er){
                    return $er->createQueryBuilder('l')->orderBy('l.nom','ASC');
                },
                'choice_label'=>'nom',
                'expanded'=>false,
                'multiple'=>false
            ])


            ->add('campus',EntityType::class,[
                'class'=>Campus::class,
                'query_builder'=>function (EntityRepository $er){
                    return $er->createQueryBuilder('c')->orderBy('c.nom','ASC');
                },
                'choice_label'=>'nom',
                'expanded'=>false,
                'multiple'=>false
            ])
            #->add('organisateur')
            #->add('participantsInscrits')
            #->add('etat')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
