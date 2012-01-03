<?php

namespace Xaddax\OpenDocumentBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction($name)
    {
        return $this->render('XaddaxOpenDocumentBundle:Default:index.html.twig', array('name' => $name));
    }
}
