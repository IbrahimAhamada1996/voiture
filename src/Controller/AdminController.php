<?php

namespace App\Controller;

use App\Entity\Admin;
use App\Form\AdminType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin/ajouter", name="admin_new")
     */
    public function new(Request $request, EntityManagerInterface $manager, UserPasswordHasherInterface $hash): Response
    {
        $admin = new Admin();

        $form  = $this->createForm(AdminType::class,$admin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $request->request->get('admin')['user'];

            $passordHash = $hash->hashPassword($admin,$data['password']['first']);
            $admin->setNom($data['nom']);
            $admin->setPrenom($data['prenom']);
            $admin->setSex($data['sex']);
            $admin->setEmail($data['email']);
            $admin->setPassword($passordHash);
            $admin->setPhone($data['phone']);
            $admin->setAdresse($data['adresse']);
            $admin->setRoles(['ROLE_ADMIN']);
            $manager->persist($admin);
        
            $manager->flush();
            // Inserer dans la basee de donné
            $this->addFlash("success", "L'operatoion se derouler avec success");
            return $this->redirectToRoute('admin_new');
        }elseif ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash("danger", "Veuillez réessayer");
        }


        return $this->render('admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/list", name="admin_list")
     */
    public function list(): Response
    {
        return $this->render('admin/list.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
}
