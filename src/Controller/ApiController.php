<?php


namespace AcMarche\EnquetePublique\Controller;

use AcMarche\EnquetePublique\Repository\EnqueteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DefaultController
 * @package AcMarche\EnquetePublique\Controller
 * @Route("/api")
 */
class ApiController extends AbstractController
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
     * @Route("/", name="enquete_publique_api")
     */
    public function index()
    {
        $url = 'https://extranet.marche.be/files/enquete_publiques/avis/';
        $enquetes = $this->enqueteRepository->findAllPublished();
        $data = [];

        foreach ($enquetes as $enquete) {
            $data1 = $documents = [];
            $data1['id'] = $enquete->getId();
            $data1['avis'] = $url.$enquete->getAvisName();
            $data1['intitule'] = $enquete->getIntitule();
            $nomCategorie = '';
            if ($categorie = $enquete->getCategorie()) {
                $nomCategorie = $categorie->getNom();
            }
            $data1['categorie'] = $nomCategorie;
            $data1['description'] = $enquete->getDescription();
            $data1['demandeur'] = $enquete->getDemandeur();
            $data1['date_fin'] = $enquete->getDateFin()->format('Y-m-d');
            $data1['date_debut'] = $enquete->getDateDebut()->format('Y-m-d');
            $data1['code_postal'] = $enquete->getCodePostal();
            $data1['numero'] = $enquete->getNumero();
            $data1['localite'] = $enquete->getLocalite();
            $data1['rue'] = $enquete->getRue();
            $data1['latitude'] = $enquete->getLatitude();
            $data1['longitude'] = $enquete->getLongitude();
            foreach ($enquete->getDocuments() as $document) {
                $documents['description'] = $document->getDescription();
                $documents['name'] = $document->getName();
            }
            $data1['documents'] = $documents;
            $data[] = $data1;
        }

        return new JsonResponse($data);

    }
}
