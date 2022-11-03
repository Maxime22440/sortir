<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Lieu;
use App\Entity\Sortie;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CreateNewFormType extends AbstractType
{


    private $em;
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }


    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom')
            ->add('dateHeureDebut')
            ->add('duree')
            ->add('dateLimiteInscription')
            ->add('nbInscriptionsMax')
            ->add('infosSortie')

//            ->add('lieu',EntityType::class,[
//                'class' => Lieu::class,
//                'query_builder'=>function (EntityRepository $er){
//                    return $er->createQueryBuilder('l')->orderBy('l.nom','ASC');
//                },
//                'choice_label'=>'nom',
//                'expanded'=>false,
//                'multiple'=>false
//            ])


//            ->add('campus',EntityType::class,[
//                'class'=>Campus::class,
//                'query_builder'=>function (EntityRepository $er){
//                    return $er->createQueryBuilder('c')->orderBy('c.nom','ASC');
//                },
//                'choice_label'=>'nom',
//                'expanded'=>false,
//                'multiple'=>false
//            ])
        ;

        $builder ->addEventListener(FormEvents::PRE_SET_DATA, [$this, 'onPreSetData']);
        $builder->addEventListener(FormEvents::PRE_SUBMIT,[$this,'onPreSubmit']);

    }

    protected function addElements(FormInterface $form, Campus $campus = null){

        $form->add('campus', EntityType::class,[
            'required'=>true,
            'data' =>$campus,
            'placeholder'=>'Choisissez un campus',
            'class'=>'AppBundle:Lieu'

        ]);

        $villes = [];
        if($campus){
            $repoVilles = $this->em->getRepository('AppBundle:Ville');

            $villes = $repoVilles->createQueryBuilder("q")
                ->where("q.campus= :campusid")
                ->setParameter("campusid",$campus->getId())
                ->getQuery()
                ->getResult();
        }


        $form->add('ville', EntityType::class,[
            'required'=>true,
            'placeholder'=>'Choisissez d\'abord un campus...',
            'class' => 'AppBundle:Ville',
            'choices' => $villes
        ]);

    }

    function onPreSubmit(FormEvent $event){

        $form = $event->getForm();
        $data = $event->getData();

        $campus = $this->em->getRepository('AppBundle:Campus')->find($data['campus']);

        $this->addElements($form, $campus);

    }


    function onPreSetData(FormEvent $event){
        $sortie = $event->getData();
        $form = $event->getForm();


        $campus = $sortie->getCampus() ? $sortie->getCampus() : null;

        $this->addElements($form,$campus);

    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'appbundle_person';
    }
}
