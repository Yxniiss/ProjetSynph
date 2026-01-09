<?php

namespace App\Controller;

use App\Form\ContactFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Annotation\Route;

class PagesController extends AbstractController
{
    #[Route('/mentions-legales', name: 'mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('pages/mentions.html.twig');
    }

    #[Route('/cgu', name: 'cgu')]
    public function cgu(): Response
    {
        return $this->render('pages/cgu.html.twig');
    }

    #[Route('/cgv', name: 'cgv')]
    public function cgv(): Response
    {
        return $this->render('pages/cgv.html.twig');
    }

    #[Route('/politique-confidentialite', name: 'politique_confidentialite')]
    public function politiqueConfidentialite(): Response
    {
        return $this->render('pages/politique.html.twig');
    }

    #[Route('/qui-sommes-nous', name: 'qui_sommes_nous')]
    public function quiSommesNous(): Response
    {
        return $this->render('pages/qui.html.twig');
    }

    #[Route('/contact', name: 'contact')]
    public function contact(Request $request, MailerInterface $mailer): Response
    {
        $form = $this->createForm(ContactFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();

            $email = (new Email())
                ->from('drif8907@gmail.com')
                ->to('drif8907@gmail.com')
                ->subject('Nouveau message depuis le site')
                ->text("Nom: {$data['name']}\nEmail: {$data['email']}\nMessage: {$data['message']}");

            $mailer->send($email);

            $this->addFlash('success', 'Votre message a été envoyé !');

            return $this->redirectToRoute('contact');
        }

        return $this->render('pages/contact.html.twig', [
            'form' => $form->createView(),
        ]);
    }

}
