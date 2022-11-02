<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;


class ProfilFormType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('Pseudo', TextType::class)
            ->add('Prénom', TextType::class)
            ->add('Nom', TextType::class)
            ->add('Telephone', TextType::class)
            ->add('Email', EmailType::class)
            ->add('Mot de passe', PasswordType::class)
            ->add('Confirmation', PasswordType::class)
            ->add('Campus', TextType::class)

            ->add('Enregistrer', ButtonType::class)
            ->add('Annuler', ButtonType::class)
        ;
    }
}
