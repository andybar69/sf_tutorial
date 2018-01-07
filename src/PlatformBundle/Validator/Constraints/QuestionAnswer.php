<?php

namespace PlatformBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * Class QuestionAnswer
 * @package PlatformBundle\Validator\Constraints
 * @Annotation
 */
class QuestionAnswer extends Constraint
{
    public $message = 'Please reply to all questions';

    public function validatedBy()
    {
        return get_class($this).'Validator';
    }
}