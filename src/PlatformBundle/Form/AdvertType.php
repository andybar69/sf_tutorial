<?php

namespace PlatformBundle\Form;

use PlatformBundle\Form\QuestionType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use PlatformBundle\Entity\Advert;
use PlatformBundle\Entity\Question;
use Symfony\Component\Validator\Constraints\NotNull;


class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class, array(
                'required' => false,
                'constraints' => array(
                    new \Symfony\Component\Validator\Constraints\NotBlank(['message' => 'Your error message']),
                )))
            ->add('author', TextType::class)
            ->add('content', TextareaType::class)
            ->add('date', DateType::class)
            ->add('published', CheckboxType::class, ['required' => false])
            ->add('questions', CollectionType::class,  array(
                'entry_type' => QuestionType::class,
                'entry_options' => array('label' => false),
                'empty_data' => null,
                'by_reference' => false,
                'constraints' => [
                    new NotNull(['message' => 'Your error message'])
                ]
            ))
            ->add('image', new ImageType())
               ->add('categories', EntityType::class, array(
                   'class'    => 'PlatformBundle:Category',
                   'choice_label' => 'name',
                   'multiple' => true,
                   'expanded' => false,
               ))
            ->add('save', SubmitType::class)
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Advert::class
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'platformbundle_advert';
    }


}
