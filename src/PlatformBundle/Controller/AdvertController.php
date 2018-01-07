<?php

namespace PlatformBundle\Controller;

use PlatformBundle\Entity\Answer;
use PlatformBundle\Form\AdvertEditType;
use PlatformBundle\Helpers\Test;
use PlatformBundle\Entity\Advert;
use PlatformBundle\Entity\Image;
use PlatformBundle\Entity\Application;
use PlatformBundle\Entity\Skill;
use PlatformBundle\Entity\AdvertSkill;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;
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
        //$this->denyAccessUnlessGranted('view');
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

        if ($form->isSubmitted() && $form->isValid()) {
            $advert = $form->getData();
            dump($advert);
            die;
            $questions = $advert->getQuestions();
            /*if ($questions) {
                foreach ($questions as $item) {
                    dump($item);
                    $answer = $item->getAnswer();
                    $advert->addAnswer($answer);
                    $answer->setQuestion($item);
                    $answer->setAdvert($advert);
                }
            }*/

            //$em->persist($answer);
            $em->persist($advert);
            $em->flush();

            $this->addFlash('add_advert_ok', 'Your advert has been successfully added!');
            return $this->redirectToRoute('platform_view', array('id' => $advert->getId()));
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
        dump($advert);
        //dump($advert->getCategories());

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        //$categories = $em->getRepository('PlatformBundle:Category')->findAll();
        $categories = $em->getRepository('PlatformBundle:Advert')->getItems($id);
        dump($categories);

        /*foreach ($categories as $category) {
            $advert->addCategory($category);
        }*/
        //$em->flush();
dump($this->getParameter('images_directory'));
        dump(realpath($this->getParameter('images_directory')));
        //$advert->setImage(new File(realpath($this->getParameter('images_directory')).'/'.$advert->getImage()));
        $path = $advert->getImage()->getWebPath();
        dump($path);
        $advert->setImage(new File($advert->getImage()->getWebPath()));
        //$o = new File($advert->getImage()->getWebPath());


        $form = $this->createForm(new AdvertEditType(), $advert);
        //dump($advert->getCategories());
        $form->handleRequest($request);

        if ($request->isMethod('POST') && $form->isValid()) {

            $advert = $form->getData();
            dump($advert);
            $categories = $advert->getCategories();

            //$em->persist($advert);
            $em->flush();

            $request->getSession()->getFlashBag()->add('notice', 'Annonce bien modifiée.');

            //return $this->redirectToRoute('platform_view', array('id' => $id));
        }

        /*$advert = array(
            'title'   => 'Recherche développpeur Symfony2',
            'id'      => $id,
            'author'  => 'Alexandre',
            'content' => 'Nous recherchons un développeur Symfony2 débutant sur Lyon. Blabla…',
            'date'    => new \Datetime()
        );*/
        //dump($path);

        return $this->render('PlatformBundle:Advert:edit.html.twig', array(
            'form' => $form->createView(),
            'pathToImage' => $path
        ));
    }

    public function deleteAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        // On récupère l'annonce $id
        $advert = $em->getRepository('OCPlatformBundle:Advert')->find($id);

        if (null === $advert) {
            throw new NotFoundHttpException("L'annonce d'id ".$id." n'existe pas.");
        }

        // On crée un formulaire vide, qui ne contiendra que le champ CSRF
        // Cela permet de protéger la suppression d'annonce contre cette faille
        $form = $this->createFormBuilder()->getForm();

        if ($form->handleRequest($request)->isValid()) {
            $em->remove($advert);
            $em->flush();

            $this->addFlash('info', "L'annonce a bien été supprimée.");

            return $this->redirect($this->generateUrl('platform_home'));

        }


        // Si la requête est en GET, on affiche une page de confirmation avant de supprimer

        return $this->render('PlatformBundle:Advert:delete.html.twig', array(
            'advert' => $advert,
            'form'   => $form->createView()
        ));
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

    public function testAction()
    {
        $advert = new Advert;

        $advert->setDate(new \Datetime());  // Champ « date » OK
        $advert->setTitle('abc');           // Champ « title » incorrect : moins de 10 caractères
        //$advert->setContent('blabla');    // Champ « content » incorrect : on ne le définit pas
        $advert->setAuthor('A');            // Champ « author » incorrect : moins de 2 caractères

        // On récupère le service validator
        $validator = $this->get('validator');

        // On déclenche la validation sur notre object
        $listErrors = $validator->validate($advert);

        // Si le tableau n'est pas vide, on affiche les erreurs
        if(count($listErrors) > 0) {

            return new Response(dump($listErrors));

        } else {

            return new Response("L'annonce est valide !");

        }

    }
}
