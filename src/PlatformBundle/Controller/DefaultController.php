<?php

namespace PlatformBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class DefaultController
 * Source: https://openclassrooms.com/courses/developpez-votre-site-web-avec-le-framework-symfony2
 * @package PlatformBundle\Controller
 */
class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('PlatformBundle:Default:index.html.twig');
    }
}
