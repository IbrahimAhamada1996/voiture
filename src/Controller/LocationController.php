<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocationController extends AbstractController
{
    /**
     * @Route("/admin/location/list", name="louer_list")
     */
    public function list(VoitureRepository $voitureRepository): Response
    {

        return $this->render('location/list.html.twig', [
            'voitures' => $voitureRepository->findAchatsOrLouer('location'),
        ]);
    }

    /**
     * @Route("/admin/louer/voiture/{id}/show", name="louer_show")
     */
    public function show(Request $request, VoitureRepository $voitureRepository,$id,UserRepository $userRepository,EntityManagerInterface $manager): Response
    {
        $voiture = $voitureRepository->find($id);
        $user_id = $request->request->get('user_id');
        // dd($user_id);
        if($user_id != null){

            // dd((int)$request->request->get('user_id'));
            $client = $userRepository->find((int)$user_id);
            $voiture->getTypeOffre()->setIsValid(true);
            $voiture->addUser($client);
    
            $manager->flush();
            $this->addFlash("success", "La validation  s'est bien dérouler avec success");
            return $this->redirectToRoute('louer_show',['id'=>$id]);
        }
        return $this->render('location/show.html.twig', [
            'voiture' =>$voiture ,
            
        ]);
    }
}
