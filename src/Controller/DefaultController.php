<?php


namespace AcMarche\EnquetePublique\Controller;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package AcMarche\EnquetePublique\Controller
 * @IsGranted("ROLE_ENQUETE_ADMIN")
 */
class DefaultController extends AbstractController
{
    /**
     * @Route("/", name="enquete_publique_home")
     */
    public function index(): Response
    {
        return $this->redirectToRoute('enquete_index');
    }
}
