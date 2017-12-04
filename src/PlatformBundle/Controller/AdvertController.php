<?php

namespace PlatformBundle\Controller;

use PlatformBundle\Entity\Answer;
use PlatformBundle\Helpers\Test;
use PlatformBundle\Entity\Advert;
use PlatformBundle\Entity\Image;
use PlatformBundle\Entity\Application;
use PlatformBundle\Entity\Skill;
use PlatformBundle\Entity\AdvertSkill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use PlatformBundle\Form\AdvertType;
use PlatformBundle\Entity\Question;

class AdvertController extends Controller
{
    public function indexAction($page)
    {
        //$env = $this->container->get('kernel')->getEnvironment();

        $listAdverts = array(
            array(
                'title'   => 'Recherche développpeur Symfony2',
                'id'      => 1,
                'author'  => 'Alexandre',
                'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
                'date'    => new \Datetime()
            ),
            array(
                'title'   => 'Mission de webmaster',
                'id'      => 2,
                'author'  => 'Hugo',
                'content' => 'Nous recherchons un webmaster capable de maintenir notre site internet. Blabla…',
                'date'    => new \Datetime()
            ),
            array(
                'title'   => 'Offre de stage webdesigner',
                'id'      => 3,
                'author'  => 'Mathieu',
                'content' => 'Nous proposons un poste pour webdesigner. Blabla…',
                'date'    => new \Datetime()
            )
        );

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PlatformBundle:Advert');
        $listAdverts = $repo->findAll();
        return $this->render('PlatformBundle:Advert:index.html.twig', array(
            'listAdverts' => $listAdverts
        ));
    }

    public function viewAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère le repository
        //$repository = $em->getRepository('PlatformBundle:Advert');
        $repository = $em->getRepository('PlatformBundle\Entity\Advert');
        //var_dump($repository);

        // On récupère l'entité correspondante à l'id $id
        $advert = $repository->find($id);

        // $advert est donc une instance de OC\PlatformBundle\Entity\Advert
        // ou null si l'id $id  n'existe pas, d'où ce if :
        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        //$res = $repository->getAdvertWithCategories(array('Graphisme'));

        //$res = $repository->myFindAll();
        //var_dump($res);
        // On récupère la liste des candidatures de cette annonce
        /*$listApplications = $em
            ->getRepository('PlatformBundle:Application')
            ->findBy(array('advert' => $advert))
        ;*/

        $listApplications = $advert->getApplications();
        //var_dump($listApplications);

        // On récupère maintenant la liste des AdvertSkill

        $listAdvertSkills = $em
            ->getRepository('PlatformBundle:AdvertSkill')
            ->findBy(array('advert' => $advert))
        ;

        return $this->render('PlatformBundle:Advert:view.html.twig', array(
            'advert' => $advert,
            'listApplications' => $listApplications,
            'listAdvertSkills' => $listAdvertSkills,
            //'result' => $res
        ));
    }

    public function addAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('PlatformBundle:Question');
        $questions = $repo->findBy(['enabled' => true]);

        $advert = new Advert();

        foreach ($questions as $question) {
            //dump($question);
            //$a = new Answer();
            //$question->setAnswer($a);
            $advert->addQuestion($question);
        }
        //dump($advert);
        $form = $this->createForm(new AdvertType(), $advert);

        $form->handleRequest($request);

        if ($form->isSubmitted() and $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $advert = $form->getData();
            $questions = $advert->getQuestions();
            foreach ($questions as $item) {
                dump($item);
                $answer = $item->getAnswer();
                $advert->addAnswer($answer);
                $answer->setQuestion($item);
                $answer->setAdvert($advert);
            }
            /*$em->persist($answer);
            $em->persist($advert);
            $em->flush();*/
            dump($form->getData());
            die;
        }

        return $this->render('PlatformBundle:Advert:add.html.twig',
            array('form' => $form->createView())
        );


        /*$antispam = $this->container->get('platform.antispam');
        $text = '...';
        //var_dump($antispam);
        if ($antispam->isSpam($text)) {
            throw new \Exception('Votre message a été détecté comme spam !');
        }*/
        $em = $this->getDoctrine()->getManager();

        $advert = new Advert();
        $advert->setTitle('PHP developer');
        $advert->setAuthor('Paul');
        $advert->setContent('Recrutons un bon back-end developer');
        $advert->setSlug('front_end_developer');

        /*$image = new Image();
        $image->setUrl('http://sdz-upload.s3.amazonaws.com/prod/upload/job-de-reve.jpg');
        $image->setAlt('Job de rêve');

        $advert->setImage($image);*/

        // Création d'une première candidature
        $application1 = new Application();
        $application1->setAuthor('Maurice');
        $application1->setContent("Bonjour.");

        $application1->setAdvert($advert);


        // Création d'une deuxième candidature par exemple
        /*$application2 = new Application();
        $application2->setAuthor('Pierre');
        $application2->setContent("Je suis très motivé.");

        // On lie les candidatures à l'annonce
        $application1->setAdvert($advert);
        $application2->setAdvert($advert);


        $em = $this->getDoctrine()->getManager();
        $em->persist($advert);

        // Étape 1 bis : pour cette relation pas de cascade lorsqu'on persiste Advert, car la relation est
        // définie dans l'entité Application et non Advert. On doit donc tout persister à la main ici.
        $em->persist($application1);
        $em->persist($application2);

        $em->flush();
*/
        $em->persist($application1);
        // On lie la candidature à l'annonce
        $advert->addApplication($application1);


        // On récupère toutes les compétences possibles
        $listSkills = $em->getRepository('PlatformBundle:Skill')->findAll();

        // Pour chaque compétence
        foreach ($listSkills as $skill) {
            // On crée une nouvelle « relation entre 1 annonce et 1 compétence »
            $advertSkill = new AdvertSkill();

            // On la lie à l'annonce, qui est ici toujours la même
            $advertSkill->setAdvert($advert);
            // On la lie à la compétence, qui change ici dans la boucle foreach
            $advertSkill->setSkill($skill);

            // Arbitrairement, on dit que chaque compétence est requise au niveau 'Expert'
            $advertSkill->setLevel('Avisé');

            // Et bien sûr, on persiste cette entité de relation, propriétaire des deux autres relations
            $em->persist($advertSkill);
        }

        // Doctrine ne connait pas encore l'entité $advert. Si vous n'avez pas définit la relation AdvertSkill
        // avec un cascade persist (ce qui est le cas si vous avez utilisé mon code), alors on doit persister $advert
        $em->persist($advert);

        // On déclenche l'enregistrement
        $em->flush();

        $session = $request->getSession();
        $session->getFlashBag()->add('info', 'Annonce bien enregistrée');

        return $this->redirectToRoute('platform_view', array('id' => $advert->getId()));

        /*$form = null;
        if ($request->isMethod('POST')) {
            $session = $request->getSession();
            $session->getFlashBag()->add('info', 'Annonce bien enregistrée');

            //return new JsonResponse(array('id' => 5, 'param' => $param, 'headers' => json_encode($headers)));

            return $this->redirectToRoute('platform_view', array('id' => 6));
        }*/
        //return $this->render('PlatformBundle:Advert:add.html.twig', array('form' => $form));
    }


    public function editAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $advert = $em->getRepository('PlatformBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        $arCategories = $em->getRepository('PlatformBundle:Category')->findAll();

        foreach ($arCategories as $category) {
            $advert->addCategory($category);
        }
        $em->flush();


        if ($request->isMethod('POST')) {
            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

            return $this->redirectToRoute('platform_view', array('id' => 5));
        }

        /*$advert = array(
            'title'   => 'Recherche développpeur Symfony2',
            'id'      => $id,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
            'date'    => new \Datetime()
        );*/

        return $this->render('PlatformBundle:Advert:edit.html.twig', array(
            'advert' => $advert
        ));
    }

    public function deleteAction($id)
    {

    }

    public function menuAction($limit)
    {
        // On fixe en dur une liste ici, bien entendu par la suite
        // on la récupérera depuis la BDD !
        $listAdverts = array(
            array('id' => 2, 'title' => 'Recherche développeur Symfony2'),
            array('id' => 5, 'title' => 'Mission de webmaster'),
            array('id' => 9, 'title' => 'Offre de stage webdesigner')
        );

        return $this->render('PlatformBundle:Advert:menu.html.twig', array(
            // Tout l'intérêt est ici : le contrôleur passe
            // les variables nécessaires au template !
            'listAdverts' => $listAdverts
        ));
    }
}
