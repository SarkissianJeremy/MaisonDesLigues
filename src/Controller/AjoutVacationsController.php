<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\AjoutVacationsType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Vacation;

class AjoutVacationsController extends AbstractController
{
    #[Route('/ajout/vacations', name: 'app_ajout_vacations')]
    public function index(Request $request, EntityManagerInterface $entityManager): Response
    {
        $vacation = new Vacation();
        
        $form = $this->createForm(AjoutVacationsType::class, $vacation);
        
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->persist($vacation);
            $entityManager->flush();
                }
        return $this->render('ajout_vacations/index.html.twig', [
            
            'formVacations' => $form->createView(),
            'controller_name' => 'AjoutVacationsController',
        ]);
    }
}
