<?php

namespace App\Controller;

use App\Repository\FootballMatchRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/match")
 */
class MatchController extends AbstractController
{
    /**
     * @Route("/dashboard", name="app.match.dashboard")
     */
    public function dashboard(Request $request, FootballMatchRepository $footballMatchRepository)
    {
        return $this->render(
            'admin/matches/dashboard.html.twig',
            [
                'matches' => $footballMatchRepository->findAll()
            ]
        );
    }
}
