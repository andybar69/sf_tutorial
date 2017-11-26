<?php
/**
 * Created by PhpStorm.
 * User: anb
 * Date: 26/11/17
 * Time: 17:42
 */

namespace PlatformBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', 'text')
            ->add('answers', ChoiceType::class, array(
                //'mapped' => false,
                'choices' => array(
                    '1' => 'Yes',
                    '0' => 'No'
                ),
                'multiple' => false,
                'expanded' => true,
                'required' => true,
                'label' => '',
            ))

        ;
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'PlatformBundle\Entity\Question'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'platformbundle_question';
    }
}