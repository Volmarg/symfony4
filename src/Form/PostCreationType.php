<?php

namespace App\Form;

use App\Entity\Posts;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class PostCreationType extends AbstractType {
    public function buildForm(FormBuilderInterface $builder, array $options) {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Post title',
                'attr' => [
                    'class' => 'form-controll',
                ]
            ])
            ->add('text', TextareaType::class, [
                'label' => "Post content",
                'attr' => [
                    'class' => 'form-controll'
                ]
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Create new Post',
                'attr' => [
                    'class' => 'form-controll btn btn-lg btn-primary btn-block'
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver) {
        $resolver->setDefaults([
            'data_class' => Posts::class,
        ]);
    }
}
