<?php

namespace AcMarche\EnquetePublique\Controller;

use AcMarche\EnquetePublique\Enquete\Message\EnqueteCreated;
use AcMarche\EnquetePublique\Enquete\Message\EnqueteDeleted;
use AcMarche\EnquetePublique\Enquete\Message\EnqueteUpdated;
use AcMarche\EnquetePublique\Entity\Enquete;
use AcMarche\EnquetePublique\Form\EnqueteType;
use AcMarche\EnquetePublique\Repository\EnqueteRepository;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/enquete')]
#[IsGranted('ROLE_ENQUETE_ADMIN')]
class EnqueteController extends AbstractController
{
    public function __construct(
        private readonly EnqueteRepository $enqueteRepository,
        private readonly MessageBusInterface $messageBus,
    ) {}

    #[Route(path: '/', name: 'enquete_index', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render(
            '@EnquetePublique/enquete/index.html.twig',
            [
                'enquetes' => $this->enqueteRepository->findOrderByDate(),
            ],
        );
    }

    #[Route(path: '/new', name: 'enquete_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $enquete = new Enquete();
        $form = $this->createForm(EnqueteType::class, $enquete);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->enqueteRepository->persist($enquete);
            $this->enqueteRepository->flush();
            $this->messageBus->dispatch(new EnqueteCreated($enquete->getId()));

            return $this->redirectToRoute('enquete_show', ['id' => $enquete->getId()]);
        }

        return $this->render(
            '@EnquetePublique/enquete/new.html.twig',
            [
                'enquete' => $enquete,
                'form' => $form->createView(),
            ],
        );
    }

    #[Route(path: '/{id}', name: 'enquete_show', methods: ['GET'])]
    public function show(Enquete $enquete): Response
    {
        return $this->render(
            '@EnquetePublique/enquete/show.html.twig',
            [
                'enquete' => $enquete,
            ],
        );
    }

    #[Route(path: '/{id}/edit', name: 'enquete_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Enquete $enquete): Response
    {
        $oldRue = $enquete->getRue();
        $form = $this->createForm(EnqueteType::class, $enquete);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->enqueteRepository->flush();
            $this->messageBus->dispatch(new EnqueteUpdated($enquete->getId(), $oldRue));

            return $this->redirectToRoute('enquete_show', ['id' => $enquete->getId()]);
        }

        return $this->render(
            '@EnquetePublique/enquete/edit.html.twig',
            [
                'enquete' => $enquete,
                'form' => $form->createView(),
            ],
        );
    }

    #[Route(path: '/{id}', name: 'enquete_delete', methods: ['POST', 'DELETE'])]
    public function delete(Request $request, Enquete $enquete): RedirectResponse
    {
        if ($this->isCsrfTokenValid('delete'.$enquete->getId(), $request->request->get('_token'))) {
            $id = $enquete->getId();
            $this->enqueteRepository->remove($enquete);
            $this->enqueteRepository->flush();
            $this->messageBus->dispatch(new EnqueteDeleted($id));
        }

        return $this->redirectToRoute('enquete_index');
    }
}
