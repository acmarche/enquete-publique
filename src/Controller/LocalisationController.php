<?php


namespace AcMarche\EnquetePublique\Controller;

use AcMarche\EnquetePublique\Entity\Enquete;
use AcMarche\EnquetePublique\Form\LocalisationType;
use AcMarche\EnquetePublique\Repository\EnqueteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LocalisationController extends AbstractController
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
     * @Route("/localisation/{id}", name="enquete_localisation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Enquete $enquete): Response
    {
        $form = $this->createForm(LocalisationType::class, $enquete);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->enqueteRepository->flush();
            $this->addFlash("success", "La géolocalisation a bien été modifiée");

            return $this->redirectToRoute('enquete_show', ['id' => $enquete->getId()]);
        }

        return $this->render(
            '@EnquetePublique/localisation/edit.html.twig',
            [
                'enquete' => $enquete,
                'form' => $form->createView(),
            ]
        );
    }

}
