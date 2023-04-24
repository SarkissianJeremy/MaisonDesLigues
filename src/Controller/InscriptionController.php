<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Inscription;
use App\Form\InscriptionType;
use Symfony\Component\HttpFoundation\Request;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request): Response
    {
        $newInscrit = new Inscription();
        $form = $this->createForm(InscriptionType::class, $newInscrit);
        
        $form->handleRequest($request);
        
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'InscriptionController',
        ]);
    }
}
