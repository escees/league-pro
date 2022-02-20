<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\LeagueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PartnersController extends AbstractController
{
    /**
     * @Route("/partners", name="app.partners")
     */
    public function partners(LeagueRepository $leagueRepository): Response
    {
        return $this->render(
            'partners.html.twig',
            [
                'leagues' => $leagueRepository->findAll(),
            ]
        );
    }
}
