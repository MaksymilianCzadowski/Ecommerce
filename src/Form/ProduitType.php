<?php

namespace App\Form;

use App\Entity\Produit;
use App\Entity\Categorie;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;

class ProduitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Nom Produit',
                    'require' => 'true'
                    ]
                ])
            ->add('description', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Description',
                ]
            ])
            ->add('prix', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Prix',
                    ]
                ])
            ->add('image', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Lien image',
                    ]
                ])
            ->add('categorie', EntityType::class, [
                    'class' => Categorie::class,
                    'choice_label' => 'titre',
                    'attr' => [
                    'class' => 'form-select',
                    'placeholder' => 'Categorie',
                    ]
                
            ])
            // ->add('user')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Produit::class,
        ]);
    }
}
