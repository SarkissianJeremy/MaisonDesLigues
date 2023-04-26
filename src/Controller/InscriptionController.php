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
use App\Entity\Licencie; 
use App\Entity\User; 
use App\Repository\LicencieRepository; 
use App\Entity\Club; 
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use App\Entity\Atelier;
use App\Entity\Theme;
use App\Entity\Hotel;
use App\Entity\Chambre;

class InscriptionController extends AbstractController
{
    #[Route('/inscription', name: 'app_inscription')]
    public function index(Request $request, ManagerRegistry $doctrine, EntityManagerInterface $manager, LicencieRepository $licencieRepo): Response
    {
        //$newInscrit = new Inscription();
        $form = $this->createForm(CreationCompteType::class);
        $form->handleRequest($request);
        
        $numlicence = "";
        
        
        if ($form->isSubmitted() && $form->isValid())
        {
            //$manager->persist($user);
            //$manager->flush();

            if(isset($form->getData()["numlicence"])) {
                $numlicence = $form->getData()["numlicence"];
                
                //dd($manager->createQueryBuilder()->select('numlicence')->from('Licencie', 'numlicence')->where('numlicence.numlicence = 16440601419'));
                
                $licencie = $doctrine->getRepository(Licencie::Class)->findOneBy(array('numlicence' => $numlicence));
                $user = $doctrine->getRepository(User::Class)->findOneBy(array('uuid' => $numlicence));
                
                if(!isset($licencie)) {
                    $themes = $doctrine->getRepository(Theme::Class)->findAll();
                    $ateliers = $doctrine->getRepository(Atelier::Class)->findAll();
                    $hotels = $doctrine->getRepository(Hotel::Class)->findAll();
                    $chambres = $doctrine->getRepository(Chambre::Class)->findAll();
                    //dd($ateliers);
                    #$manager->persist()
                    #$manager->flush()

                    return $this->render('main/index.html.twig', [
                        'controller_name' => 'MainController',
                        'ateliers' => $ateliers,
                        'themes' => $themes,
                        'hotels' => $hotels,
                        'chambres' => $chambres,
                    ]);
                }
                if(isset($user))
                {
                    
                }
                if(isset($form->getData()["plainPassword"]) && !isset($user))
                {
                    $date = new \DateTime();
                    $newUser = new User();
                        $newUser->setPassword($form->getData()["plainPassword"]);
                        $newUser->setUuid($numlicence);
                        $newUser->setDateInscription(new \DateTime());
                        $newUser->setDateEnregistrementArrivee(new \DateTime());
                     
                    require_once('../vendor/autoload.php');    
                        
                    $credentials = \SendinBlue\Client\Configuration::getDefaultConfiguration()->setApiKey('api-key', 'xsmtpsib-286c116e2205a90808303e86a5d0a89a01a240e003cb79857eea615c4153f297-vPJnL4ftZErCsOQB');
                    $apiInstance = new \SendinBlue\Client\Api\TransactionalEmailsApi(new \GuzzleHttp\Client(['verify' => false]),$credentials);

                    $sendSmtpEmail = new \SendinBlue\Client\Model\SendSmtpEmail([
                         'subject' => 'from the PHP SDK!',
                         'sender' => ['name' => 'Sendinblue', 'email' => 'jonathan.simonhuver@gmail.com'],
                         'replyTo' => ['name' => 'Sendinblue', 'email' => 'jonathan.simonhuver@gmail.com'],
                         'to' => [[ 'name' => 'Max Mustermann', 'email' => 'example@example.com']],
                         'htmlContent' => '<html><body><h1>This is a transactional email {{params.bodyMessage}}</h1></body></html>',
                         'params' => ['bodyMessage' => 'made just for you!']
                    ]);

                    try {
                        $result = $apiInstance->sendTransacEmail($sendSmtpEmail);
                        print_r($result);
                    } catch (Exception $e) {
                        echo $e->getMessage(),PHP_EOL;
                    } 
                    
                    $manager->persist($newUser);
                    $manager->flush();
                }
            }
        }
        
        
        
        return $this->render('inscription/index.html.twig', [
            'form' => $form->createView(),
            'controller_name' => 'InscriptionController',
        ]);
    }
}
