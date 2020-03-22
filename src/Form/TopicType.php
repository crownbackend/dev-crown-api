<?php

namespace App\Form;

use App\Entity\Forum;
use App\Entity\Topic;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, [
                "label" => "Titre",
                 "attr" => [
                    "class" => "form-control"
                ],
            ])
            ->add('description', TextareaType::class, [
                "label" => "Description",
                 "attr" => [
                    "class" => "form-control ckeditor"
                ],
            ])
            ->add('resolve', CheckboxType::class, [
                "label" => "Résolu",
                "required" => false
            ])
            ->add('close',CheckboxType::class, [
                "label" => "Fermer le sujet",
                "required" => false
            ])
            ->add('forum', EntityType::class, [
                "class" => Forum::class,
                "choice_label" => "name",
                "placeholder" => "Choisire un forum",
                "attr" => [
                    "class" => "form-control"
                ],
                "required" => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}
