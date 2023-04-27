<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Inscription;
use App\Form\InscriptionType;
use App\Form\ChangeMailType;
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
        $user = $this->getUser();
        $uneInscription = $doctrine->getRepository(Inscription::Class)->findOneBy(array('user' => $user->getId(), 'is_validated' => false));
        if(isset($uneInscription))
        {
            return $this->redirectToRoute('app_validation');
        }
        
        $newInscription = new Inscription();
        $form = $this->createForm(InscriptionType::class, $newInscription);
        
        $formMail = $this->createForm(ChangeMailType::class);
        $formMail->handleRequest($request);
        
        $form->handleRequest($request);
        
        $licencie = $doctrine->getRepository(Licencie::Class)->findOneBy(array('numlicence' => $user->getNumLicence()));
        $prix = 0;
        
       if ($formMail->isSubmitted())
       {
          
           $licencie->setMail($formMail->getData()['mail']);
           $user->setEmail($formMail->getData()['mail']);
           $entityManager->persist($licencie);
           $entityManager->persist($user);
           $entityManager->flush();
       }
        
        if ($form->isSubmitted() && $form->isValid()) {
            
            $newInscription->setUser($user);
            $newInscription->setIsValidated(false);
            
            if ($newInscription->getAteliers()->count() > 5)
            {
                //return $this->redirectToRoute('app_main');
                return $this->redirect($this->generateUrl('app_main', array('error' => "Vous ne pouvez pas vous inscrire a plus de 5 ateliers!")));
            }

            $entityManager->persist($newInscription);
            $entityManager->flush();
            return $this->redirectToRoute('app_validation');
        }
        
        return $this->render('inscription/index.html.twig', [
            'inscriptionForm' => $form->createView(),
            'mailForm' => $formMail->createView(),
            'licencie' => $licencie,
            'prix' => $prix,
            'controller_name' => 'InscriptionController',
        ]);
    }
}
