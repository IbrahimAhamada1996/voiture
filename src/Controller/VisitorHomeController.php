<?php

namespace App\Controller;

use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitorHomeController extends AbstractController
{
    
    /**
     * @Route("/", name="visitor_home")
     */
    public function index(VoitureRepository $voitureRepository): Response
    {
       
        return $this->render('visitor_home/index.html.twig', [
            'voitures' => $voitureRepository->findOffrePublie('vendre','location'),
        ]);
    }
}
