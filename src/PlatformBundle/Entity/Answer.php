<?php

namespace PlatformBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Answer
 *
 * @ORM\Table(name="answers")
 * @ORM\Entity(repositoryClass="PlatformBundle\Repository\AnswerRepository")
 */
class Answer
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
     * @ORM\ManyToMany(targetEntity="PlatformBundle\Entity\Question", inversedBy="answers")
     * @ORM\JoinTable(name="answers_questions")
     */
    private $question;


    public function __construct()
    {
        $this->question = new ArrayCollection();

    }

    /**
     * @var bool
     *
     * @ORM\Column(name="result", type="boolean")
     */
    private $result;


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
        $this->question[] = $question;

        return $this;
    }

    public function getQuestion()
    {
        return $this->question;
    }
}

