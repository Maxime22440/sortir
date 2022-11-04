<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Repository\LieuRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateNewFormType extends AbstractType
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    private function getLieuRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Lieu::class);
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom',TextType::class)
            ->add('dateHeureDebut',IntegerType::class)
            ->add('duree',IntegerType::class)
            ->add('dateLimiteInscription',IntegerType::class)
            ->add('nbInscriptionsMax',IntegerType::class)
            ->add('infosSortie',TextType::class)

            ->add('ville',EntityType::class,[
                'class' => Ville::class,

                'query_builder'=>function (EntityRepository $er){
                    return $er->createQueryBuilder('v')->orderBy('v.nom','ASC');
                },
                'choice_label'=>'nom',
                'mapped'=>false,
                'expanded'=>false,
                'multiple'=>false,
                'placeholder' => 'Choose an option',
            ])
        ;


        //On veut les lieux en fonction de la ville


        $builder->addEventListener(FormEvents::PRE_SET_DATA,function (FormEvent $event) {

//            if (null !== $event->getData()->getVille()) {
//                // we don't need to add the friend field because
//                // the message will be addressed to a fixed friend
//                return;
//            }


            $form = $event->getForm();

            $lieu = [
                'class' => Lieu::class,
                'query_builder' => function (EntityRepository $er){
                    return $er->createQueryBuilder('l')->orderBy('l.nom','ASC');
                },
                'choice_label'=>'nom',
                'expanded'=>false,
                'multiple'=>false

            ];


            $form->add('lieu', EntityType::class, $lieu);

        });
    }


    function onPreSubmit(FormEvent $event){


    }


    protected function addElements(FormInterface $form, Ville $ville = null){



        $form->add('ville', EntityType::class,[
            'required'=>true,
            'data' =>$ville,
            'placeholder'=>'Choisissez une ville',
            'class'=> Ville::class

        ]);

        $lieux = [];


    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }

}
