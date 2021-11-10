<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Post;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('image', FileType::class,[
                'label' => 'Главное изображение',
                'required' => false,
                'mapped' => false
            ])
            ->add('category', EntityType::class,[
                'label' => 'Категории',
                'class' => Category::class,
                'choice_label' => 'title',
            ])
            ->add('title', TextType::class,[
                'label' => 'Заголовок поста',
                'attr' => [
                    'placeholder' => 'Введите текст'
                ]
            ])
            ->add('content', TextareaType::class,[
                'label' => 'Текст поста',
                'attr' => [
                    'placeholder' => 'Введите текст поста'
                ]
            ])
            ->add('save', SubmitType::class,[
                'label' => 'Сохранить',
                'attr' => [
                    'class' => 'btn btn-success'
                ]
            ])
            ->add('delete', SubmitType::class,[
                'label' => 'Удалить',
                'attr' => [
                    'class' => 'btn btn-danger'
                ]
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
