<?php

namespace AcMarche\EnquetePublique\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use AcMarche\EnquetePublique\Entity\Categorie;
use AcMarche\EnquetePublique\Form\CategorieType;
use AcMarche\EnquetePublique\Repository\CategorieRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/categorie")
 * @IsGranted("ROLE_ENQUETE_ADMIN")
 */
class CategorieController extends AbstractController
{
    private CategorieRepository $categorieRepository;

    public function __construct(CategorieRepository $categorieRepository)
    {
        $this->categorieRepository = $categorieRepository;
    }

    /**
     * @Route("/", name="enquete_categorie_index", methods={"GET"})
     */
    public function index(): Response
    {
        return $this->render(
            '@EnquetePublique/categorie/index.html.twig',
            [
                'categories' => $this->categorieRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/new", name="enquete_categorie_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categorieRepository->persist($categorie);
            $this->categorieRepository->flush();

            $this->addFlash('success', 'La catégorie a bien été ajoutée');

            return $this->redirectToRoute('enquete_categorie_show', ['id' => $categorie->getId()]);
        }

        return $this->render(
            '@EnquetePublique/categorie/new.html.twig',
            [
                'categorie' => $categorie,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="enquete_categorie_show", methods={"GET"})
     */
    public function show(Categorie $categorie): Response
    {
        return $this->render(
            '@EnquetePublique/categorie/show.html.twig',
            [
                'categorie' => $categorie,
            ]
        );
    }

    /**
     * @Route("/{id}/edit", name="enquete_categorie_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Categorie $categorie): Response
    {
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->categorieRepository->flush();
            $this->addFlash('success', 'La catégorie a bien été modifiée');

            return $this->redirectToRoute('enquete_categorie_show', ['id' => $categorie->getId()]);
        }

        return $this->render(
            '@EnquetePublique/categorie/edit.html.twig',
            [
                'categorie' => $categorie,
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{id}", name="enquete_categorie_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Categorie $categorie): Response
    {
        if ($this->isCsrfTokenValid('delete'.$categorie->getId(), $request->request->get('_token'))) {
            $this->categorieRepository->remove($categorie);
            $this->categorieRepository->flush();
            $this->addFlash('success', 'La catégorie a bien été supprimée');
        }

        return $this->redirectToRoute('enquete_categorie_index');
    }
}
