<?php

namespace App\Controller;

use App\Dictionary\FlashType;
use App\Entity\News;
use App\Entity\Player;
use App\Form\NewsType;
use App\Form\PlayerType;
use App\Repository\NewsRepository;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/news")
 */
class NewsController extends AbstractController
{
    /**
     * @Route(
     *     "/{news}/view",
     *     name="app.news.view",
     * )
     */
    public function view(Request $request, News $news): Response
    {
        return $this->render(
            'single-news.html.twig',
            [
                'news' => $news
            ]
        );
    }
}
