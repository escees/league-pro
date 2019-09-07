<?php

namespace App\Controller\Admin;

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
 * @Route("/admin/news")
 */
class AdminNewsController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/list", name="app.admin.news.list")
     */
    public function dashboard(Request $request, NewsRepository $newsRepository): Response
    {
        return $this->render(
            'admin/news/list.html.twig',
            [
                'news' => $newsRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/add", name="app.admin.news.add")
     */
    public function add(Request $request): Response
    {
        $form = $this->createForm(NewsType::class, $news = new News());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($news);
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'News został poprawnie dodany');

            return $this->redirectToRoute('app.admin.news.list');
        }

        return $this->render('admin/news/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{news}/edit", name="app.admin.news.edit")
     */
    public function edit(Request $request, News $news): Response
    {
        $form = $this->createForm(NewsType::class, $news);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'News został poprawnie edytowany');

            return $this->redirectToRoute('app.admin.news.list');
        }

        return $this->render('admin/news/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{news}/publish", name="app.admin.news.publish")
     */
    public function publish(Request $request, News $news): Response
    {
        $news->publish();
        $this->entityManager->persist($news);
        $this->entityManager->flush();

        $this->addFlash(FlashType::WARNING, 'News został opublikowany');

        return $this->redirectToRoute('app.admin.news.list');
    }

    /**
     * @Route(
     *     "/{news}/delete",
     *     name="app.admin.news.delete",
     * )
     */
    public function delete(Request $request, News $news): Response
    {
        $this->entityManager->remove($news);
        $this->entityManager->flush();

        $this->addFlash(FlashType::DANGER, 'News został usunięty!');

        return $this->redirectToRoute('app.admin.news.list');
    }

    /**
     * @Route(
     *     "/{news}/view",
     *     name="app.admin.news.view",
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
