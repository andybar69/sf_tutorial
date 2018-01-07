<?php

namespace PlatformBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;


class QuestionAnswerValidator extends ConstraintValidator
{
    public function validate($value, Constraint $constraint)
    {
        dump($value);
        foreach ($value as $question) {
            if (is_null($question->getAnswer()->getResult())) {
                $this->context->buildViolation($constraint->message)
                    ->setParameter('{{ string }}', $value)
                    ->atPath('questions')
                    ->addViolation();

                break;
            }
        }
        dump($this->context);
    }
}