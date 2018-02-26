<?php

namespace Drupal\api\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

final class ArticleType extends AbstractType
{

    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 3, 'max' => 100])
                    ],
                ]
            )
            ->add('body', TextareaType::class,
                [
                    'constraints' => [
                        new NotBlank(),
                        new Length(['min' => 10])
                    ],
                ]
            );
    }
}

