<?php

namespace App\Form;

use App\Entity\Offre;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Form\CategoryType;
use App\Entity\Categorie;

class OffreType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class)
            ->add('expmin',IntegerType::class,array('attr'=>array('min'=>1)))
            ->add('expmax',IntegerType::class,array('attr'=>array('max'=>5)))
            ->add('technologies',TextType::class)
            ->add('langue',TextType::class)
            ->add('nbheures',IntegerType::class,array('attr'=>array('max'=>8)))
            ->add('diplome',TextType::class)
            ->add('etat',CheckboxType::class)
            ->add('categorie',EntityType::class,['class' => Categorie::class,
                                            'choice_label' => 'nom'  ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
            ])
        ;
    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Offre::class,
        ]);
    }
}
