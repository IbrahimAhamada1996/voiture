<?php

namespace App\Controller;

use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Length;

class OffreController extends AbstractController
{
    private $manager;
    public function __construct(EntityManagerInterface $manager) {
       $this->manager = $manager;
   }
    /**
     * @Route("/offre/show/{id}", name="offre_show")
     */
    public function show($id): Response
    {
            // dd($this->manager->getRepository(Voiture::class)->find($id));
        return $this->render('offre/show.html.twig', [
            'voiture' => $this->manager->getRepository(Voiture::class)->find($id),
        ]);
    }

    /**
     * @Route("/offre/{id}/panier", name="offre_panier")
     */
    public function panier($id,SessionInterface $session): Response
    {
       $voiture =  $this->manager->getRepository(Voiture::class)->find($id);
        if (!$this->getUser()) {
            $this->addFlash("danger", "Connectez-Vous avant d'achater ou louer");
            return $this->redirectToRoute('app_login');
        }
        $user = $this->getUser();
        $voiture->getTypeOffre()->setAjoutInPanier(true);
        $user->addVoiture($voiture);
        

        $this->manager->flush();
        
        $this->addFlash("success", "Nous avons bien reçu votre démande, Nous vous contacterons");
        
       return $this->redirectToRoute('offre_show',['id'=>$id]);
    }
}
