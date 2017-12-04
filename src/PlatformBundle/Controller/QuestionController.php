<?php

namespace PlatformBundle\Controller;

use PlatformBundle\Form\QuestionType;
use PlatformBundle\Entity\Question;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use PlatformBundle\Form\QuestionAdminType;

class QuestionController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PlatformBundle:Question');
        $list = $repo->findAll();

        return $this->render('PlatformBundle:Question:index.html.twig', [
            'list' => $list
        ]);


    }

    public function addAction(Request $request)
    {
        $question = new Question();
        $form = $this->createForm(new QuestionAdminType(), $question);

        $form->handleRequest($request);

        if ($form->isSubmitted() /*&& $form->isValid()*/) {
            $em = $this->getDoctrine()->getManager();
            $question = $form->getData();
            $em->persist($question);
            $em->flush();
        }

        return $this->render('PlatformBundle:Question:add.html.twig',[
            'form' => $form->createView()
        ]);

    }

    public function editAction($id, Request $request)
    {

    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $question = $em->getRepository('PlatformBundle:Question')->find($id);
        $em->remove($question);
        $em->flush();

        return $this->render('PlatformBundle:Question:index.html.twig', [
            //'list' => $list
        ]);
    }
}