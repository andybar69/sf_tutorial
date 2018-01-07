<?php

namespace PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Context\ExecutionContextInterface;


/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="PlatformBundle\Repository\QuestionRepository")
 */
class Question
{
    /**
     * @Assert\Callback()
     */
    public function validate(ExecutionContextInterface $context)
    {
        if ($this->getAnswer()->getResult() === null) {
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
     * @var string
     *
     * @ORM\Column(name="text", type="text")
     */
    private $text;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     */
    private $enabled;

    /****
     * @ORM\OneToMany(targetEntity="PlatformBundle\Entity\Answer", mappedBy="question", cascade="{persist}")
     * @ORM\JoinColumn(nullable=false)
     * @Assert\IsValid()
     */
    private $answer;




    public function __construct()
    {
        //$this->advert = new ArrayCollection();
        //$this->answer = new ArrayCollection();
        //dump(__CLASS__);
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
     * Set text
     *
     * @param string $text
     *
     * @return Question
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Question
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * @param $val
     * @return $this
     */
    public function setAnswer($val)
    {
        $this->answer = $val;

        return $this;
    }

    /*public function addAnswer($answer)
    {
        $this->answer[] = $answer;

        return $this;
    }

    public function removeAnswer($answer)
    {
        $this->answer->removeElement($answer);
    }*/

    /**
     * @return mixed
     */
    public function getAnswer()
    {
        return $this->answer;
    }

    /**
     * @param $advert
     * @return $this
     */
    /*public function setAdvert($advert)
    {
        $this->advert[] = $advert;

        return $this;
    }*/

    /**
     * @return ArrayCollection
     */
    /*public function getAdvert()
    {
        return $this->advert;
    }*/

}

