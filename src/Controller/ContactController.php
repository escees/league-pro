<?php

declare(strict_types=1);

namespace App\Controller;

use App\Repository\LeagueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="app.contact")
     */
    public function partners(LeagueRepository $leagueRepository): Response
    {
        return $this->render(
            'contact2.html.twig',
            [
                'leagues' => $leagueRepository->findAll(),
            ]
        );
    }
}
