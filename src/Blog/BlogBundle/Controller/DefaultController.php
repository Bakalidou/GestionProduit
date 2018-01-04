<?php

namespace Blog\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="pages/view_post_route")
     */
    public function indexAction()
    {
        return $this->render('BlogBundle:Default:index.html.twig');
    }



}
