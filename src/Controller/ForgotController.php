<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\ForgotFormType;
use App\Security\EmailVerifier;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mime\Address;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use SymfonyCasts\Bundle\VerifyEmail\Exception\VerifyEmailExceptionInterface;
use App\Entity\Licencie;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Doctrine\Persistence\ManagerRegistry;

class ForgotController extends AbstractController
{
    private EmailVerifier $emailVerifier;

    public function __construct(EmailVerifier $emailVerifier)
    {
        $this->emailVerifier = $emailVerifier;
    }

    #[Route('/forgot', name: 'app_forgot')]
    public function forgot(Request $request, UserPasswordHasherInterface $userPasswordHasher, EntityManagerInterface $entityManager, ManagerRegistry $doctrine): Response
    {
        $user = new User();
        $form = $this->createForm(ForgotFormType::class, $user);
        $form->handleRequest($request);
        
        
        if($form->isSubmitted() && !$form->isValid())
        {
            $user = $doctrine->getRepository(User::Class)->findOneBy(array('numlicence' => $form->get('numLicence')->getData()));
            if(isset($user))
            {
                return $this->redirectToRoute('app_login');
            } 
        }
        
        if ($form->isSubmitted() && $form->isValid()) {
            $licencie = $doctrine->getRepository(Licencie::Class)->findOneBy(array('numlicence' => $form->get('numLicence')->getData()));
            if (!isset($licencie))
            {
                return $this->redirect($this->generateUrl('app_main', array('error' => "Ce numéro de licence n'existe pas !")));
            }
            
            // encode the plain password
            $user->setPassword(
                $userPasswordHasher->hashPassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );

            dd($form->getData());
            
            $user->setDateInscription(new \DateTime());
            $user->setDateEnregistrementArrivee(new \DateTime());
            $licencie = $doctrine->getRepository(Licencie::Class)->findOneBy(array('numlicence' => $form->get('numLicence')->getData()));
            $user->setEmail($licencie->getMail());
            
            $entityManager->persist($user);
            $entityManager->flush();

            // generate a signed url and email it to the user
            $this->emailVerifier->sendEmailConfirmation('app_verify_email', $user,
                (new TemplatedEmail())
                    ->from(new Address('app@mdl.fr', 'MDLBot'))
                    ->to($user->getEmail())
                    ->subject('Please Confirm your Email')
                    ->htmlTemplate('forgot/confirmation_email.html.twig')
            );
            // do anything else you need here, like send an email

            return $this->redirectToRoute('app_main');
        }

        return $this->render('forgot/forgot.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }

    #[Route('/verify/email', name: 'app_verify_email')]
    public function verifyUserEmail(Request $request): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        // validate email confirmation link, sets User::isVerified=true and persists
        try {
            $this->emailVerifier->handleEmailConfirmation($request, $this->getUser());
        } catch (VerifyEmailExceptionInterface $exception) {
            $this->addFlash('verify_email_error', $exception->getReason());

            return $this->redirectToRoute('app_forgot');
        }

        // @TODO Change the redirect on success and handle or remove the flash message in your templates
        $this->addFlash('success', 'Your email address has been verified.');

        return $this->redirectToRoute('app_forgot');
    }
}
