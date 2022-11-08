<?php

namespace App\Form;

use App\Entity\Campus;
use App\Entity\Participant;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ProfilFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('username', TextType::class,[
                'label' => false
            ])
            ->add('nom', TextType::class,[
                'label' => false
            ])
            ->add('prenom', TextType::class,[
                'label' => false
            ])
            ->add('telephone', TextType::class,[
                'label' => false
            ])
            ->add('mail', EmailType::class,[
                'label' => false
            ])
            ->add('campus', EntityType::class,[
                'class'=> Campus::class,
                'choice_label'=>'nom',
                'label' => false
            ])
            ->add('password2',RepeatedType::class,[

                'mapped'=> false,
                'type' => PasswordType::class,
                'invalid_message' => 'Veuillez renseigner le meme mot de passe.',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => false,
                'first_options'  => ['label' => false],
                'second_options' => ['label' => false],
                'attr' => ['autocomplete' => 'new-password'],
                'constraints' => [

                    new Length([
                        'min' => 6,
                        'minMessage' => 'votre mot de passe doit comporter au moins {{ limit }} caractères',
                        'max' => 4096,
                    ]),
                ],
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Participant::class,
        ]);
    }
}