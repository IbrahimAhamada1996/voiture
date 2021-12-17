<?php

namespace App\Controller;

use App\Entity\Visiteur;
use App\Form\VisiteurType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class InscriptionController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription")
     */
    public function index(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hash): Response
    {
        $visiteur = new Visiteur();

        $form  = $this->createForm(VisiteurType::class,$visiteur);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('visiteur')['user'];

            $passordHash = $hash->hashPassword($visiteur,$data['password']['first']);
            $visiteur->setNom($data['nom']);
            $visiteur->setPrenom($data['prenom']);
            $visiteur->setSex($data['sex']);
            $visiteur->setEmail($data['email']);
            $visiteur->setPassword($passordHash);
            $visiteur->setPhone($data['phone']);
            $visiteur->setAdresse($data['adresse']);
            $visiteur->setRoles(['ROLE_VISITEUR']);
            $manager->persist($visiteur);
        
            $manager->flush();
            // Inserer dans la basee de donné
            $this->addFlash("success", "L'operatoion se derouler avec success");
            return $this->redirectToRoute('inscription');
        }elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash("danger", "Veuillez réessayer");
        }

        // if(!!$this->getUser()){
        //     $this->getUser()->setRoles(['ROLE_VISITEUR']);
        //     $manager->flush();
        //     dd($this->getUser());

        // }
        return $this->render('inscription/index.html.twig', [
           'form'=>$form->createView(),
        ]);
    }

  


}
