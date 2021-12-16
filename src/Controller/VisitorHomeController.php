<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitorHomeController extends AbstractController
{
    /**
     * @Route("/", name="visitor_home")
     */
    public function index(): Response
    {
        return $this->render('visitor_home/index.html.twig', [
            'controller_name' => 'VisitorHomeController',
        ]);
    }
}
