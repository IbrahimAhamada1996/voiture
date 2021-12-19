<?php

namespace App\Controller;

use App\Entity\Acheter;
use App\Entity\Image;
use App\Entity\Louer;
use App\Entity\Offre;
use App\Entity\Voiture;
use App\Form\VoitureType;
use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VoitureAdminController extends AbstractController
{
    private $manager;
     public function __construct(EntityManagerInterface $manager) {
        $this->manager = $manager;
    }
    /**
     * @Route("/admin/voiture/list", name="voiture_admin_list")
     */
    public function list(): Response
    {
        // dd( $this->manager->getRepository(Voiture::class)->findAll());
    //    dd($this->getUser());
        return $this->render('voiture_admin/list.html.twig', [
            'voitures' => $this->manager->getRepository(Voiture::class)->findAll(),
        ]);
    }


    /**
     * @Route("/admin/voiture/ajouter", name="voiture_admin_new")
     */
    public function new(Request $request): Response
    {
        
            $voiture = new Voiture;
    
        $form = $this->createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $voiture->setCreatedAt(new DateTimeImmutable());

            $images = $form->get("images")->getData();
          
            foreach ($images as $k => $image) {
               $file = md5(uniqid()).".".$image->guessExtension();
               
               $image->move($this->getParameter("image_directory"),$file);
               $img = new Image();
               $img->setNom( $file);
               $voiture->addImage($img);
                
            }
           
            $this->manager->persist($voiture);
            $this->manager->flush();
            $this->addFlash("success", "L'operatoion se derouler avec success");
            return $this->redirectToRoute('voiture_admin_new');
        } elseif ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash("danger", "Veuillez réessayer");
        } 
      
        return $this->render('voiture_admin/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/admin/voiture/{id}/modifier", name="voiture_admin_update")
     */
    public function update(Request $request,$id): Response
    {
        $voiture = $this->manager->getRepository(Voiture::class)->find($id);
        $form = $this->createForm(VoitureType::class,$voiture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $voiture->setCreatedAt(new DateTimeImmutable());

            $images = $form->get("images")->getData();
          
            foreach ($images as $k => $image) {
               $file = md5(uniqid()).".".$image->guessExtension();
               
               $image->move($this->getParameter("image_directory"),$file);
               $img = new Image();
               $img->setNom( $file);
               $voiture->addImage($img);
                
            }
           
            $this->manager->persist($voiture);
            $this->manager->flush();
            $this->addFlash("success", "L'operatoion se derouler avec success");
            return $this->redirectToRoute('voiture_admin_show',['id'=>$voiture->getId()]);
        } elseif ($form->isSubmitted() && $form->isValid()) {
            $this->addFlash("danger", "Veuillez réessayer");
        } 
      
        return $this->render('voiture_admin/new.html.twig', [
            'form' => $form->createView(),
            'voiture'=>$voiture,
        ]);
    }

     /**
     * @Route("/admin/voiture/{id}/show", name="voiture_admin_show")
     */
    public function show($id,Request $request): Response
    {
       $voiture = $this->manager->getRepository(Voiture::class)->find($id);
       $type = $request->request->get('type');
       $montant = (float)$request->request->get('montant');
       $promotion = (float)$request->request->get('promotion');
    //    dd($type,$montant,$promotion);
       if (null != $type && null != $montant) {
            $typeOffre =null;
            $offre = new Offre;
            if ($type=='Vendre') {
                $typeOffre = new Acheter;
                $voiture->setTypeVoiture('vendre');
            }elseif($type=='Location'){
                $typeOffre = new Louer;
                $voiture->setTypeVoiture('location');
            }
            
            $offre->setMontant($montant);
            $offre->setPromotion($promotion);
            $offre->setCreatedAt(new DateTimeImmutable());
            $typeOffre->setOffre($offre);
            $voiture->setTypeOffre($typeOffre);

            
            // dd($voiture);
           
            $this->manager->persist($voiture);
            $this->manager->persist($offre);
            $this->manager->persist($typeOffre);
            $this->manager->flush();
            $this->addFlash("success", "L'operatoion se derouler avec success");
            return $this->redirectToRoute('offre_admin_voiture_show',['id'=>$id]);
        }else{

            $this->addFlash("danger", "Veuiller selection le type d'offre , entrer le prix et éventuellement le prix de la promotion");
        }
        return $this->render('voiture_admin/show.html.twig', [
            'voiture' => $voiture,
        ]);
    }

      /**
     * @Route("/admin/voiture/{id}/delete", name="voiture_admin_delete",methods={"DELETE"})
     */
    public function delete(Request $request,$id): Response
    {
        $image = $this->manager->getRepository(Image::class)->find($id);
        $data = json_decode($request->getContent(),true);
        //dd($data);
         if($this->isCsrfTokenValid("delete".$image->getId(),$data["_token"]))
         {
             $nom = $image->getNom();
             
             unlink($this->getParameter("image_directory")."/".$nom);
             $this->manager->remove($image);
             $this->manager->flush();
 
             return new JsonResponse(["success" => 1]);
         }else{
             return new JsonResponse(["error" => 0]);
         }
      
      
      
        
        return $this->render('voiture_admin/new.html.twig', [
            
        ]);
    }

}
