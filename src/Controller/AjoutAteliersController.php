<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutAteliersType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Atelier;
class AjoutAteliersController extends AbstractController
{
    #[Route('/ajout/ateliers', name: 'app_ajout_ateliers')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {     
        $atelier = new Atelier();
        
        $form = $this->createForm(AjoutAteliersType::class, $atelier);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($atelier);
            $entityManager->flush();
        }
        return $this->render('/ajout_ateliers/index.html.twig', [
            
            'formAteliers' => $form->createView(),
            
            'controller_name' => 'AjoutAteliersController',
        ]);
    }
}

