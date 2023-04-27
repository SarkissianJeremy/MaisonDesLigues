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
use App\Entity\Licencie;

use Doctrine\Persistence\ManagerRegistry;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $newInscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $newInscription);
        $form->handleRequest($request);
        $user = $this->getUser();
        $licencie = $doctrine->getRepository(Licencie::Class)->findOneBy(array('numlicence' => $user->getNumLicence()));
        $prix = null;
        
        if ($form->isSubmitted() && $form->isValid()) {
            $newInscription->setUser($user);
            $coutInscriptionCongret;
            $coutRestauration = $newInscription->getRestauration()->count()*35;
            $prix=$coutInscriptionCongret + $coutRestauration;
           
            $entityManager->persist($newInscription);
            $entityManager->flush();
        }
        
        return $this->render('inscription/index.html.twig', [
            'inscriptionForm' => $form->createView(),
            'licencie' => $licencie,
            'prix' => $prix,
            'controller_name' => 'InscriptionController',
        ]);
    }
}
