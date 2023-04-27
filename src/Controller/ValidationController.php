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
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

class ValidationController extends AbstractController
{
    #[Route('/validation', name: 'app_validation')]
    public function index(Request $request, EntityManagerInterface $entityManager, ManagerRegistry $doctrine, MailerInterface $mailer): Response
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
            
        $stylecss = '<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootswatch/4.5.2/cerulean/bootstrap.min.css">
                    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
                    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
                    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.min.js" integrity="sha384-cuYeSxntonz0PPNlHhBs68uyIAVpIIOZZ5JqeqvYYIcEL727kskC66kF92t6Xl2V" crossorigin="anonymous"></script>

                    <style>
                        .example-wrapper { margin: 1em auto; max-width: 800px; width: 95%; font: 18px/1.5 sans-serif; }
                        .example-wrapper code { background: #F5F5F5; padding: 2px 6px; }
                    </style>';
        $format = '<h1> Confirmation inscription et récapitulatif </h1>
                    <h2> Informations utilisateur </h2>
                    <div>
                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="inputEmail4">Nom</label>
                            <input type="text" class="form-control" value="%s" disabled>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="inputPassword4">Prenom</label>
                            <input type="text" class="form-control" value="%s" disabled>
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="inputEmail4">Qualité</label>
                            <input type="text" class="form-control" value="%s" disabled>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="inputPassword4">Numéro Licence</label>
                            <input type="text" class="form-control" value="%s" disabled>
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="inputCity">Adresse</label>
                            <input type="text" class="form-control" value="%s" disabled>
                          </div>
                          <div class="form-group col-md-4">
                            <label for="inputState">Ville</label>
                            <input type="text" class="form-control" value="%s" disabled>
                          </div>
                          <div class="form-group col-md-2">
                            <label for="inputZip">Cp</label>
                            <input type="text" class="form-control" value="%s" disabled>
                          </div>
                        </div>

                        <div class="form-row">
                          <div class="form-group col-md-6">
                            <label for="inputEmail4">Email</label>
                            <input type="text" class="form-control"  value="%s" disabled>
                          </div>
                          <div class="form-group col-md-6">
                            <label for="inputPassword4">Tel</label>
                            <input type="text" class="form-control"  value="%s" disabled>
                          </div>
                        </div>
                    </div> 
                <hr class="hr" />
                <h2> Ateliers choisis </h2>';
       
        $licencie = ($doctrine->getRepository(Licencie::Class)->findOneBy(array('numlicence' => $user->getNumLicence())));
        $ateliers = $inscription->getAteliers();
        $chambres = $inscription->getChambres();
        $restaurations = $inscription->getRestauration();

        foreach ($ateliers as $atelier){
            $format = $format . '<li> ' . $atelier . ' </li>';
        }
        
        $format = $format . '<hr class="hr" /><h2> Chambres choisis </h2>';

        foreach ($chambres as $chambre){
            $format = $format . '<li> ' . $chambre . ' </li>';
        }
        
        $format = $format . '<hr class="hr" /><h2> Repas choisis </h2>';

        foreach ($restaurations as $restauration){
            $format = $format . '<li> ' . $restauration . ' </li>';
        }
        
        $format = $format . '<a class="btn btn-lg btn-danger" href="#">
                                    Prix : ' . $prix . ' €
                               </a>';

        if ($form->isSubmitted()) 
        {
            $email = (new Email())
                ->from('app@mdl.fr')
                ->to($user->getEmail())
                //->cc('cc@example.com')
                //->bcc('bcc@example.com')
                //->replyTo('fabien@example.com')
                //->priority(Email::PRIORITY_HIGH)
                ->subject('Confirmation inscription :')
                ->html($stylecss . sprintf($format, $licencie->getNom(),
                        $licencie->getPrenom(),
                        $licencie->getQualite()->getLibellequalite(),
                        $licencie->getNumLicence(),
                        $licencie->getAdresse1(),
                        $licencie->getVille(),
                        $licencie->getCp(),
                        $licencie->getMail(),
                        $licencie->getTel()));

            $mailer->send($email);
        
            $inscription = $doctrine->getRepository(Inscription::Class)->findOneBy(array('user' => $user->getId(), 'is_validated' => false));
            $inscription->setIsValidated(true);
            $entityManager->persist($inscription);
            $entityManager->flush();
            return $this->redirectToRoute('app_main');
        }
            
        
        

        
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
