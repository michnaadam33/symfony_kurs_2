<?php


namespace App\Controller;


use App\Entity\Visit;
use App\Form\VisitFormType;
use App\Repository\VisitRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;

class VisitController extends AbstractController
{
    /**
     * @Route("/add-visit")
     * @return Response
     */
    public function addVisit(EntityManagerInterface $entityManager, Request $request): Response
    {
        $this->denyAccessUnlessGranted('ROLE_PATIENT');

        $visit = new Visit();
        $visitForm = $this->createForm(VisitFormType::class, $visit);
        $visitForm->handleRequest($request);
        if ($visitForm->isSubmitted() && $visitForm->isValid()){
            $entityManager->persist($visit);
            $visit->setPatient($this->getUser());
            $endDate = clone $visit->getStartDate();
            $visit->setEndDate($endDate->add(new \DateInterval('PT1H')));
            $entityManager->flush();

            return $this->redirectToRoute('app_visit_listvisit');
        }
        return $this->render('visit/add.html.twig', ['visitForm' => $visitForm->createView()]);
    }

    /**
     * @Route("/list-visits")
     * @param VisitRepository $visitRepository
     * @return Response
     */
    public function listVisit(VisitRepository $visitRepository): Response
    {
        $this->denyAccessUnlessGranted('ROLE_PATIENT');

        $visits = $visitRepository->findByPatient($this->getUser());

        return $this->render('visit/list.html.twig', ['visits' => $visits]);

    }
}