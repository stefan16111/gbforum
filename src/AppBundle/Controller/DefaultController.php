<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $category = $this->getDoctrine()->getRepository('AppBundle:Category')->findAllAsc();
        
        return $this->render('index.html.twig',
                array('categories' => $category)
        );
    }
 
    /**
     * @Route("/faq", name="faq")
     */
    public function questionPageAction(Request $request)
    {
        
        return $this->render('index.html.twig'
        );
    }
}
