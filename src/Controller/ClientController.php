<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    /**
     * @Route("/admin/client", name="client_list")
     */
    public function list(): Response
    {
        return $this->render('client/list.html.twig', [
            'controller_name' => 'ClientController',
        ]);
    }
}
