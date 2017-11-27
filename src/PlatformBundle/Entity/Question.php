<?php

namespace PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Question
 *
 * @ORM\Table(name="question")
 * @ORM\Entity(repositoryClass="PlatformBundle\Repository\QuestionRepository")
 */
class Question
{
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
     * @ORM\OneToOne(targetEntity="PlatformBundle\Entity\Answer", mappedBy="questions", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $answer;

    /**
     * @ORM\ManyToMany(targetEntity="PlatformBundle\Entity\Advert", inversedBy="questions", cascade={"persist"})
     */
    private $advert;

    //private $choice;


    public function __construct()
    {
        $this->advert = new ArrayCollection();
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

    /*public function getChoice()
    {
        return $this->choice;
    }

    public function setChoice($choice)
    {
        $this->choice = $choice;
    }*/

    public function setAnswer($val)
    {
        //$this->answers = $val;
        $this->answer = new Answer();
        $this->answer->setResult($val);
    }

    public function getAnswer()
    {
        return $this->answer;
        //return $this->answers->getResult();
    }

    public function setAdvert($advert)
    {
        $this->advert[] = $advert;

        return $this;
    }

    public function getAdvert()
    {
        return $this->advert;
    }

}

