<?php
declare(strict_types=1);

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ContactRepository;
use App\Service\ContactServiceInterface;
use App\Service\TrackServiceInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact", methods={"GET"})
     */
    public function index(FormFactoryInterface $formFactory, ContactRepository $contactRepository): Response
    {
        $contacts = $contactRepository->findAll();
        $form = $formFactory->create(ContactType::class);
        return $this->render('contact/index.html.twig', [
            'form' => $form->createView(),
            'contacts' => $contacts
        ]);
    }

    /**
     * @Route("/contact", name="create_contact", methods={"POST"})
     */
    public function post(Request $request, ContactServiceInterface $contactService, FormFactoryInterface $formFactory): Response
    {

        $contact = new Contact();
        $form = $formFactory->create(ContactType::class, $contact);
        $form->submit($request->request->all());

        if (!$form->isValid()) {
            return new Response('Invalid form', 404);
        }

        $contactService->addContact($contact);

        return new Response('Adding contact successful');
    }

    /**
     * @Route("/contact/{contact}/_track", name="update_contact", methods={"POST"})
     */
    public function track(Contact $contact, TrackServiceInterface $trackService): Response
    {
        $trackService->track($contact);
        return new Response('Tracked successful');
    }
}
