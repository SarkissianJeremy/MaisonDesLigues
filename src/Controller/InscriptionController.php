<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Entity\User;
use App\Entity\Restauration;
use Doctrine\ORM\EntityManagerInterface;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $newInscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $newInscription);
        $form->handleRequest($request);
        
        
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($newInscription);
            $entityManager->flush();
        }
        
        return $this->render('inscription/index.html.twig', [
            'inscriptionForm' => $form->createView(),
            'controller_name' => 'InscriptionController',
        ]);
    }
}
