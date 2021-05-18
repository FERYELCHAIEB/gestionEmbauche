<?php

namespace App\Form;

use App\Entity\Demande;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Form\CategoryType;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
class DemandeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('titre',TextType::class,['required'=>true])
            ->add('budget',IntegerType::class,array('attr'=>array('min'=>1200)))
            ->add('diplome',TextType::class)
            ->add('technologie',TextType::class) 
            ->add('langue',TextType::class)
            ->add('categorie',EntityType::class,['class' => Categorie::class,
                                            'choice_label' => 'nom'  ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Demande::class,
        ]);
    }
}
