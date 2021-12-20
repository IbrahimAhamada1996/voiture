<?php

namespace App\Controller;

use App\Repository\AcheterRepository;
use App\Repository\ClientRepository;
use App\Repository\UserRepository;
use App\Repository\VoitureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AchatController extends AbstractController
{
    /**
     * @Route("/admin/achat/list", name="achat_list")
     */
    public function list(VoitureRepository $voitureRepository): Response
    {
        
        return $this->render('achat/list.html.twig', [
            'voitures' => $voitureRepository->findAchatsOrLouer('vendre'),
        ]);
    }

    /**
     * @Route("/admin/achat/voiture/{id}/show", name="achat_show")
     */
    public function show(Request $request, VoitureRepository $voitureRepository,$id,UserRepository $userRepository,EntityManagerInterface $manager): Response
    {
        $voiture = $voitureRepository->find($id);
        $user_id = $request->request->get('user_id');
        $client = null;
        if($user_id != null){

            // dd((int)$request->request->get('user_id'));
            $client = $userRepository->find((int)$user_id);
            $voiture->getTypeOffre()->setIsValid(true);
            $voiture->addUser($client);
    
            $manager->flush();
            $this->addFlash("success", "La validation  s'est bien dérouler avec success");
            return $this->redirectToRoute('achat_show',['id'=>$id]);
        }
      
        return $this->render('achat/show.html.twig', [
            'voiture' =>$voiture ,
            
        ]);
    }
}
