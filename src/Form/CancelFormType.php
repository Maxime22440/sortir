<?php

namespace App\Form;

use App\Entity\Sortie;
use App\Repository\SortieRepository;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CancelFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder

            ->add('infosSortie', TextareaType::class, ['label' => 'Motif'])
            ->add('annulerSortie', SubmitType::class, ['label' => 'Confirmer l\'annulation de la sortie'])
            ->add('garderSorite', SubmitType::class, ['label' => 'Garder la sortie'])



        ;
    }



    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Sortie::class,
        ]);
    }
}
