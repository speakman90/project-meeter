<?php

namespace App\Form;

use App\Entity\Gender;
use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                    'label_attr' => ['class'=>'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                    'attr' => ['class'=> 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500', 
                                'placeholder'=> 'name@domain.com'],
                    'constraints' => [
                        new NotBlank([
                            'message' => 'Nous avons besoins de ton mail',
                        ]),
                    ],
                    'required' => true
            ])
            ->add('userName', TextType::class, [
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'attr' => ['class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Nous avons besoins de ton prénom',
                    ]),
                ],
                'required' => true,
            ])
            ->add('birthDate', DateType::class, [
                'widget' => 'single_text',
                'attr' => [ 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pl-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
                            'placeholder' => "Ta date d'anniversaire"
                        ],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'label'=>"Date d'anniversaire",
                'constraints' => [
                    new NotBlank([
                        'message' => "Nous avons besoins de ton connaître ta date d'anniversaire",
                    ]),
                    new Callback(function($object, ExecutionContextInterface $context) {
                        $start = Date("Y");
                        if (intval($start) - intval($object->format('Y')) < 18) {
                                $context
                                    ->buildViolation("Tu doit être majeur pour t'inscrire")
                                    ->addViolation();
                        }
                    }),
                ],
                'required' => true
            ])
            ->add('gender', EntityType::class, [
                'class' => gender::class,
                'choice_label' => 'name',
                'label_attr' => ['class'=>'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'label' => 'Votre genre',
                'attr' => [ 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'required' => true,
                'constraints' => [
                    new NotBlank([
                        'message' => "Nous avons besoins de ton connaître ton genre",
                    ]),
                ],
            ])
            // ->add('profilPhotos', FileType::class, [
            //     'data_class'=> null,
            //     'multiple'=> true,
            //     'attr' => [ 'class' => 'block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400',
            //                 'accept' => 'image/*',
            //                 'multiple' => 'multiple'
            //             ],
            //     'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
            //     'label'=>"Média",
            //     'required' => false
            // ])
            ->add('agreeTerms', CheckboxType::class, [
                'attr' => ['class' => 'rounded-t rounded-b'],
                'mapped' => false,
                'label' => " J'accepte les CGU",
                'label_attr' => ['class'=> 'ml-2 text-sm font-medium text-gray-900 dark:text-gray-300'],
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'required' => true
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'attr' => ['autocomplete' => 'new-password', 'class' => 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500'],
                'label_attr' => ['class' => 'block mb-2 text-sm font-medium text-gray-900 dark:text-white'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a password',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Your password should be at least {{ limit }} characters',
                        'max' => 4096,
                    ]),
                ],
                'required' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
