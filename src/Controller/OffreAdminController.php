<?php

namespace App\Controller;

use App\Entity\Acheter;
use App\Entity\Louer;
use App\Entity\Voiture;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OffreAdminController extends AbstractController
{
     private $manager;
     public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }
    /**
     * @Route("/offre/admin", name="offre_admin")
     */
    public function index(): Response
    {
        return $this->render('offre_admin/index.html.twig', [
            'controller_name' => 'OffreAdminController',
        ]);
    }

    /**
     * @Route("/admin/offre/vente/list", name="offre_admin_list_vente")
     */
    public function list_vente(VoitureRepository $voitureRepository): Response
    {
        $voitures = $voitureRepository->findByTypeoffre('vendre');
        return $this->render('offre_admin/list_vente.html.twig', [
            'voitures' => $voitures,
        ]);
    }

     /**
     * @Route("/admin/offre/location/list", name="offre_admin_list_location")
     */
    public function list_location(VoitureRepository $voitureRepository): Response
    {
        $voitures = $voitureRepository->findByTypeoffre('location');
        // dd($voitures);
        return $this->render('offre_admin/list_location.html.twig', [
            'voitures' => $voitures,
        ]);
    }

    /**
     * @Route("/admin/offre/{id}/show", name="offre_admin_voiture_show")
     */
    public function show($id): Response
    {
        $voiture = $this->manager->getRepository(Voiture::class)->find($id);
        // dd($voiture);
        return $this->render('offre_admin/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }
}
