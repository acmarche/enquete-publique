<?php

namespace AcMarche\EnquetePublique\Controller;

use AcMarche\EnquetePublique\Entity\Enquete;
use AcMarche\EnquetePublique\Form\EnqueteType;
use AcMarche\EnquetePublique\Repository\EnqueteRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/enquete")
 * @IsGranted("ROLE_PATRIMOINE_ADMIN")
 */
class EnqueteController extends AbstractController
{
    /**
     * @var EnqueteRepository
     */
    private $enqueteRepository;

    public function __construct(EnqueteRepository $enqueteRepository)
    {
        $this->enqueteRepository = $enqueteRepository;
    }

    /**
     * @Route("/", name="enquete_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render(
            '@EnquetePublique/enquete/index.html.twig',
            [
                'enquetes' => $this->enqueteRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="enquete_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $enquete = new Enquete();
        $form = $this->createForm(EnqueteType::class, $enquete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->enqueteRepository->persist($enquete);
            $this->enqueteRepository->flush();

            return $this->redirectToRoute('enquete_show', ['id' => $enquete->getId()]);
        }

        return $this->render(
            '@EnquetePublique/enquete/new.html.twig',
            [
                'enquete' => $enquete,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="enquete_show", methods={"GET"})
     */
    public function show(Enquete $enquete): Response
    {
        return $this->render(
            '@EnquetePublique/enquete/show.html.twig',
            [
                'enquete' => $enquete,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="enquete_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Enquete $enquete): Response
    {
        $form = $this->createForm(EnqueteType::class, $enquete);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->enqueteRepository->flush();


            return $this->redirectToRoute('enquete_show', ['id' => $enquete->getId()]);
        }

        return $this->render(
            '@EnquetePublique/enquete/edit.html.twig',
            [
                'enquete' => $enquete,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="enquete_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Enquete $enquete): Response
    {
        if ($this->isCsrfTokenValid('delete'.$enquete->getId(), $request->request->get('_token'))) {
            $this->enqueteRepository->remove($enquete);
            $this->enqueteRepository->flush();
        }

        return $this->redirectToRoute('enquete_index');
    }
}
