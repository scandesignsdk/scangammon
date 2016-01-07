<?php

namespace ViewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpKernel\Kernel;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     */
    public function indexAction()
    {
        return $this->render(':index:index.html.twig', [
            'symfony' => Kernel::VERSION,
            'php' => sprintf('%s.%s', PHP_MAJOR_VERSION, PHP_MINOR_VERSION)
        ]);
    }

}
