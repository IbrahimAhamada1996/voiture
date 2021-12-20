<?php

namespace App\Controller;

use App\Repository\VoitureRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class VisitorHomeController extends AbstractController
{
    
    /**
     * @Route("/", name="visitor_home")
     */
    public function index(VoitureRepository $voitureRepository,Request $request,PaginatorInterface $paginator): Response
    {
    //    dd($request);
         $type =strtolower($request->query->get('type'));
         $promo = strtolower($request->query->get('promo'));
        
    
        $queryVoitures =  $voitureRepository->findOffrePublie('vendre','location');
         if ($type !=null || $promo != null) {
            
            $queryVoitures =  $voitureRepository->findOffrePublieSearch($type,$promo);
         }

         $voitures = $paginator->paginate(
            $queryVoitures, /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            8 /*limit per page*/
        );
        
        return $this->render('visitor_home/index.html.twig', [
            'voitures' => $voitures,
        ]);
    }
}
