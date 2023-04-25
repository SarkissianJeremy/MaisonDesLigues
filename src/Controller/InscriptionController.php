<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Inscription;
use App\Form\CreationCompteType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Chambre; 
use App\Entity\Licencie; 
use App\Entity\Club; 

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $manager): Response
    {
        //$newInscrit = new Inscription();
        $form = $this->createForm(CreationCompteType::class);
        $form->handleRequest($request);
        
        $numlicence = "";
        
        if ($form->isSubmitted() && $form->isValid())
        {
            //$manager->persist($user);
            //$manager->flush();
            $numlicence = $form->getData()["numlicence"];
            
            
            
            $user = $doctrine->getRepository(Licencie::Class)->findOneBy(array('numlicence' => $numlicence));
            
            dd($user);
        }
        
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'InscriptionController',
        ]);
    }
}
