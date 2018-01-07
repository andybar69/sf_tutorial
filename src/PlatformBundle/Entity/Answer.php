<?php

namespace PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Answer
 *
 * @ORM\Table(name="answers")
 * @ORM\Entity(repositoryClass="PlatformBundle\Repository\AnswerRepository")
 */
class Answer
{
    /**
     * @Assert\Callback()
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->result === null) {
            $context->buildViolation('Either a preset, or a manual entry must be supplied')->addViolation();
        }

        /*if ($this->getPresetChoice() !== null && $this->getManualEntry() !== null) {
            $context->buildViolation('Cannot use both a preset and a manual entry')->addViolation();
        }*/
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bool
     *
     * @ORM\Column(name="result", type="boolean")
     * @Assert\NotNull(message="please fill in")
     */
    private $result;

    /**
     * @ORM\ManyToOne(targetEntity="PlatformBundle\Entity\Question", inversedBy="answer", cascade={"persist"})
     * @ORM\JoinColumn(name="question_id", referencedColumnName="id", nullable=false, onDelete="CASCADE")
     */
    private $question;

    /**
     * @var Advert $advert
     *
     * @ORM\ManyToOne(targetEntity="PlatformBundle\Entity\Advert", inversedBy="answer", cascade={"persist"})
     * @ORM\JoinColumn(name="advert_id", referencedColumnName="id", nullable=false)
     */
    private $advert;


    public function __construct()
    {
        //$this->question = new ArrayCollection();
        dump(__METHOD__);
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set result
     *
     * @param boolean $result
     *
     * @return Answer
     */
    public function setResult($result)
    {
        $this->result = $result;

        return $this;
    }

    /**
     * Get result
     *
     * @return bool
     */
    public function getResult()
    {
        return $this->result;
    }

    public function setQuestion(Question $question)
    {
        $this->question = $question;

        return $this;
    }

    public function getQuestion()
    {
        return $this->question;
    }

    public function setAdvert($advert)
    {
        $this->advert = $advert;

        return $this;
    }

    public function getAdvert()
    {
        return $this->advert;
    }

    public function __toString()
    {
        return 'answer';
    }
}

