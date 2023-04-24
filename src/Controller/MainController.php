<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Atelier;


class MainController extends AbstractController
{
    #[Route('', name: 'app_main')]
    public function index(ManagerRegistry $doctrine, EntityManagerInterface $manager): Response
    {
        $ateliers = $doctrine->getRepository(Atelier::Class)->findAll();
        //dd($ateliers);
        #$manager->persist()
        #$manager->flush()
        
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
            'ateliers' => $ateliers,
        ]);
    }
}
