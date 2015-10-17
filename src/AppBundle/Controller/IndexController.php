<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Class IndexController
 * @package AppBundle\Controller
 *
 * @Route("/")
 */
class IndexController extends Controller
{

    /**
     * @Route("/", name="index_index")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->renderView(':index:index.html.twig');
    }

}
