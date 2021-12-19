<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
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
        $client = new Client();

        $form  = $this->createForm(ClientType::class,$client);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('client')['user'];

            $passordHash = $hash->hashPassword($client,$data['password']['first']);
            $client->setNom($data['nom']);
            $client->setPrenom($data['prenom']);
            $client->setSex($data['sex']);
            $client->setEmail($data['email']);
            $client->setPassword($passordHash);
            $client->setPhone($data['phone']);
            $client->setAdresse($data['adresse']);
            $client->setRoles(['ROLE_CLIENT']);
            $manager->persist($client);
        
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
