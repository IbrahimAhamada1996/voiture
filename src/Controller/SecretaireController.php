<?php

namespace App\Controller;

use App\Entity\Secretaire;
use App\Form\SecretaireType;
use App\Repository\SecretaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class SecretaireController extends AbstractController
{
    

     /**
     * @Route("/admin/secretaire/ajouter", name="secretaire_new")
     */
    public function new(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hash): Response
    {
        $secretaire = new Secretaire;

        $form  = $this->createForm(SecretaireType::class,$secretaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('secretaire')['user'];

            $passordHash = $hash->hashPassword($secretaire,$data['password']['first']);
            $secretaire->setPrenom($data['prenom']);
            $secretaire->setSex($data['sex']);
            $secretaire->setNom($data['nom']);
            $secretaire->setEmail($data['email']);
            $secretaire->setPassword($passordHash);
            $secretaire->setPhone($data['phone']);
            $secretaire->setAdresse($data['adresse']);
            $secretaire->setRoles(['ROLE_SECRETAIRE']);
            $manager->persist($secretaire);
        
            $manager->flush();
            // Inserer dans la basee de donné
            $this->addFlash("success", "L'operatoion se derouler avec success");
            return $this->redirectToRoute('secretaire_new ');
        }elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash("danger", "Veuillez réessayer");
        }

        return $this->render('secretaire/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/secretaire/list", name="secretaire_list")
     */
    public function list(SecretaireRepository $secretaireRepository): Response
    {
        return $this->render('secretaire/list.html.twig', [
            'secretaires' => $secretaireRepository->findAll(),
        ]);
    }
}
