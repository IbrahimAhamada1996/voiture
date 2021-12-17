<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisiteurController extends AbstractController
{
    /**
     * @Route("/admin/visiteur", name="visiteur_list")
     */
    public function list(): Response
    {
        return $this->render('visiteur/list.html.twig', [
            'controller_name' => 'VisiteurController',
        ]);
    }
}
