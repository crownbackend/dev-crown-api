<?php

namespace App\Form;

use App\Entity\Video;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class VideoType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Titre"
            ])
            ->add('description', TextareaType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Description"
            ])
            ->add('videoURL', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "L'url youtube"
            ])
            ->add('nameFileVideo', TextType::class, [
                "attr" => [
                    "class" => "form-control"
                ],
                "label" => "Le nom de la vidéo à télécharger"
            ])
            ->add('publishedAt', DateTimeType::class, [
                'widget' => 'single_text',
                // prevents rendering it as type="date", to avoid HTML5 date pickers
                'html5' => false,
                // adds a class that can be selected in JavaScript
                'attr' => [
                    'class' => 'js-datepicker'
                ],
            ])
            ->add('imageFile', FileType::class, [
                'label' => 'Image',
                'mapped' => false,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Video::class,
        ]);
    }
}
