<?php

namespace PlatformBundle\Form;

use PlatformBundle\Form\QuestionType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class AdvertType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', 'text')
            ->add('author', 'text')
            ->add('content', 'textarea')
            ->add('date', 'date')
            ->add('published', 'checkbox', array('required' => false))
            ->add('questions', CollectionType::class,  array(
                'entry_type' => QuestionType::class,
                'entry_options' => array('label' => false),
                //'mapped' => false,
                /*'choices' => array(
                    '1' => 'Yes',
                    '0' => 'No'
                ),
                'multiple' => false,
                'expanded' => true,
                'required' => true,*/
            ))
            /*->add('question1' ,  ChoiceType::class, array(
                    'mapped' => false,
                    //'data' => 'abcdef'
                'choices' => array(
                    'male' => 'Male',
                    'female' => 'Female'
                ),
                'multiple' => false,
                'expanded' => true,
                'required' => true,
                'data'     => 'male',
                'label' => 'Are you sure that...'
            ))
            ->add('question2' ,  ChoiceType::class, array(
                'mapped' => false,
                //'data' => 'abcdef'
                'choices' => array(
                    '1' => 'Yes',
                    '0' => 'No'
                ),
                'multiple' => false,
                'expanded' => true,
                'required' => true,
                'data'     => 'male',
                'label' => 'Are you sure that...'
            ))*/
            //->add('image')
            //->add('categories')
            ->add('save', 'submit')
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlatformBundle\Entity\Advert'
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
