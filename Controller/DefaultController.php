<?php

namespace Brother\CMSBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BrotherCMSBundle:Default:index.html.twig', array('name' => $name));
    }
}
