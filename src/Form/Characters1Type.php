<?php

namespace App\Form;

use App\Entity\Characters;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class Characters1Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextareaType::class, [
                'label' => false,
            ])
            ->add('height', TextareaType::class, [
                'label' => false,
            ])
            ->add('weight', TextareaType::class, [
                'label' => false,
            ])
            ->add('age', TextareaType::class, [
                'label' => false,
            ])
            ->add('description', TextareaType::class, [
                'label' => false,
            ])
            ->add('image', FileType::class, [
                'label' => false,
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Characters::class,
        ]);
    }
}
