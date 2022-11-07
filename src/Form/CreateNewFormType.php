<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Participant;
use App\Entity\Sortie;
use App\Entity\Ville;
use App\Repository\LieuRepository;
use Doctrine\DBAL\Types\TextType;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;

class CreateNewFormType extends AbstractType
{

    private $entityManager;
    private Security $security;



    public function __construct(EntityManagerInterface $entityManager, Security $security)
    {
        $this->entityManager = $entityManager;
        $this->security= $security;
    }





    private function getLieuRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Lieu::class);
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $campus = $this->security->getUser()->getCampus();


        $builder
            ->add('nom')
            ->add('dateHeureDebut')
            ->add('duree')
            ->add('dateLimiteInscription')
            ->add('nbInscriptionsMax')
            ->add('infosSortie')



            ->add('campus', EntityType::class, [
                'class' => Campus::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('c');
                },
                'data' => $campus,
                'choice_label' => 'nom',
//                'disabled' => true,
            ])



            ->add('ville', EntityType::class, [
                'class' => Ville::class,

                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('v')->orderBy('v.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'mapped' => false,
                'expanded' => false,
                'multiple' => false,
                'placeholder' => 'Choose an option',
            ])
            ->add('lieu', EntityType::class, [
                'class' => Lieu::class,
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('l')->orderBy('l.nom', 'ASC');
                },
                'choice_label' => 'nom',
                'expanded' => false,
                'multiple' => false

            ])



        ->add('Enregistrer', SubmitType::class, ['label' => 'Enregistrer'])
        ->add('Enregistrer_et_publier', SubmitType::class, ['label' => 'Publier la sortie']);

    }









        //On veut les lieux en fonction de la ville

//        $builder->addEventListener(FormEvents::PRE_SET_DATA,function (FormEvent $event) {
//
////            if (null !== $event->getData()->getVille()) {
////                // we don't need to add the friend field because
////                // the message will be addressed to a fixed friend
////                return;
////            }
//
//            $form = $event->getForm();
//
//            $lieu = [
//                'class' => Lieu::class,
//                'query_builder' => function (EntityRepository $er){
//                    return $er->createQueryBuilder('l')->orderBy('l.nom','ASC');
//                },
//                'choice_label'=>'nom',
//                'expanded'=>false,
//                'multiple'=>false
//
//            ];
//
//            $form->add('lieu', EntityType::class, $lieu);
//
//
////                $form->add('nouveauFormulaire', LieuType::class);
//
//
//        });
//    }

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
