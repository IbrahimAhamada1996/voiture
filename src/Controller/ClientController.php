<?php

namespace App\Controller;

use App\Repository\ClientRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    /**
     * @Route("/admin/client", name="client_list")
     */
    public function list(ClientRepository $clientRepository): Response
    {
        // dd($clientRepository->findAll());
        return $this->render('client/list.html.twig', [
            'clients' => $clientRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/client/{id}show", name="client_show")
     */
    public function show($id,ClientRepository $clientRepository): Response
    {
        $client = $clientRepository->find($id);
        return $this->render('client/list.html.twig', [
            'client' => $client,
        ]);
    }
}
