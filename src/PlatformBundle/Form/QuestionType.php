<?php

namespace PlatformBundle\Form;

use PlatformBundle\Entity\Answer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use PlatformBundle\Entity\Question;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Validator\Constraints\NotNull;

class QuestionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('text', TextType::class)
            ->add('answer', ChoiceType::class, array(
               // 'mapped' =>false,
                'choices' => array(
                    '1' => 'Yes',
                    '0' => 'No'
                ),
                'multiple' => false,
                'expanded' => true,
                'required' => false,
                'label' => '',
                //'choices_as_values' => true,
                'constraints' => [
                    new NotNull(['message' => 'Your error message'])
                ]
            ))
        ;

        $builder->get('answer')
            ->addModelTransformer(new CallbackTransformer(
                function ($property) {
                    return (string) $property;
                },
                function ($property) {
                    //return (bool) $property;
                    $answer = new Answer();
                    $answer->setResult($property);
                    return $answer;
                }
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => Question::class
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