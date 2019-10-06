<?php


namespace App\Controller;


use App\Entity\Visit;
use App\Form\VisitFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class VisitController extends AbstractController
{
    /**
     * @Route("/add-visit")
     * @return Response
     */
    public function addVisit(): Response
    {
        $visit = new Visit();
        $visitForm = $this->createForm(VisitFormType::class, $visit);
        return $this->render('visit/add.html.twig', ['visitForm' => $visitForm->createView()]);
    }
}