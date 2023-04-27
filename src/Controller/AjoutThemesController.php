<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutThemesType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Theme;

class AjoutThemesController extends AbstractController
{
    #[Route('/ajout/themes', name: 'app_ajout_themes')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {          
        $theme = new Theme();
        
        $form = $this->createForm(AjoutThemesType::class, $theme);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($theme);
            $entityManager->flush();
                }
        return $this->render('/ajout_themes/index.html.twig', [
            'formThemes' => $form->createView(),
            
            'controller_name' => 'AjoutAteliersController',
        ]);
    }           
}

