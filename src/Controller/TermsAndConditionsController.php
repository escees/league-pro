<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\LeagueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TermsAndConditionsController extends AbstractController
{
    /**
     * @Route("/terms-and-conditions", name="app.terms_and_conditions")
     */
    public function termsAndConditions(LeagueRepository $leagueRepository): Response
    {
        return $this->render(
            'terms_and_conditions.html.twig',
            [
                'leagues' => $leagueRepository->findAll(),
            ]
        );
    }
}
