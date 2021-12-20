<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\AcheterRepository;
use App\Repository\LouerRepository;
use App\Repository\VoitureRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin/home", name="admin_home")
     */
    public function index(LouerRepository $louerRepository,VoitureRepository $voitureRepository,AcheterRepository $acheterRepository): Response
    {
        $nombreVoitureLouer = 0;
        $nombreVoitureVendu = 0;
    

        foreach ($louerRepository->findAll() as $key => $value) {
                
                if ($value->getIsValid()) {
                    $nombreVoitureLouer ++;
                    $nombreVoitureVendu ++;
                }
            
        }
        // dd($voitureRepository->findAchatsOrLouer('vendre','location'));
        // dd($nombreVoitureLouer,$nombreVoitureVendu);
        return $this->render('admin_home/index.html.twig', [
            'voitures' => $voitureRepository->findAchatsOrLouerAndValid('vendre','location'),
            'enLocation'=>$louerRepository->findAll(),
            'enVente'=>$acheterRepository->findAll(),
        ]);
    }
}
