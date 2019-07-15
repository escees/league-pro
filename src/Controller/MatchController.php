<?php

namespace App\Controller;

use App\Form\MatchType;
use App\Repository\FootballMatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Proxies\__CG__\App\Entity\FootballMatch;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/match")
 */
class MatchController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dashboard", name="app.match.dashboard")
     */
    public function dashboard(Request $request, FootballMatchRepository $footballMatchRepository)
    {
        $form = $this->createForm(MatchType::class, $match = new FootballMatch());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($match);
            $this->entityManager->flush();
        }

        return $this->render(
            'admin/matches/dashboard.html.twig',
            [
                'matches' => $footballMatchRepository->findAll(),
                'form' => $form->createView()
            ]
        );
    }

//    public function add(Request $request)
//    {
//
//    }
}
