<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Persistence\ManagerRegistry;
use App\Entity\Inscription;
use App\Entity\Licencie;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Doctrine\ORM\EntityManagerInterface;

class ValidationController extends AbstractController
{
    #[Route('/validation', name: 'app_validation')]
    public function index(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $user = $this->getUser();
        $inscription = $doctrine->getRepository(Inscription::Class)->findOneBy(array('user' => $user->getId(), 'is_validated' => false));

        $prix=0;
        
        $test=null;
        $form = $this->createForm(CheckboxType::class, $test, [
            'label' => 'Approuvé'
        ]);
        $form->handleRequest($request);
        
        if(isset($inscription))
        {
            $coutInscriptionCongret = 110;
            $coutRestauration = $inscription->getRestauration()->count()*35;
            foreach ($inscription->getChambres() as $chambre) {
                $prix = $prix + $chambre->getTarif();
            }
           
            $prix = $prix + $coutInscriptionCongret + $coutRestauration;


        if ($form->isSubmitted()) 
        {
            $inscription = $doctrine->getRepository(Inscription::Class)->findOneBy(array('user' => $user->getId(), 'is_validated' => false));
            $inscription->setIsValidated(true);
            $entityManager->persist($inscription);
            $entityManager->flush();
            return $this->redirectToRoute('app_main');
        }
            
        $licencie = ($doctrine->getRepository(Licencie::Class)->findOneBy(array('numlicence' => $user->getNumLicence())));
        
        $ateliers = $inscription->getAteliers();
        $chambres = $inscription->getChambres();
        $restaurations = $inscription->getRestauration();
        
        //dd($inscription);
        return $this->render('validation/index.html.twig', [
            'formTest' => $form->createView(),
            'licencie' => $licencie,
            'ateliers' => $ateliers,
            'chambres' => $chambres,
            'restaurations' => $restaurations,
            'prix' => $prix,
            'controller_name' => 'ValidationController',
        ]);
        } else {
            return $this->render('validation/index.html.twig', [
            'controller_name' => 'ValidationController',
            'error' => "Vous n'avez pas d'inscription a valider"
        ]);
        }
    }
}
