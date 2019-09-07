<?php

namespace App\Controller\Admin;

use App\Dictionary\FlashType;
use App\Entity\League;
use App\Entity\News;
use App\Entity\Player;
use App\Form\LeagueType;
use App\Form\NewsType;
use App\Form\PlayerType;
use App\Repository\LeagueRepository;
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
 * @Route("/admin/league")
 */
class AdminLeagueController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dashboard", name="app.admin.league.dashboard")
     */
    public function dashboard(Request $request, LeagueRepository $leagueRepository): Response
    {
        return $this->render(
            'admin/league/dashboard.html.twig',
            [
                'leagues' => $leagueRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/add", name="app.admin.league.add")
     */
    public function add(Request $request): Response
    {
        $form = $this->createForm(LeagueType::class, $league = new League());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($league);
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Liga została poprawnie dodana');

            return $this->redirectToRoute('app.admin.league.dashboard');
        }

        return $this->render('admin/league/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{league}/edit", name="app.admin.league.edit")
     */
    public function edit(Request $request, League $league): Response
    {
        $form = $this->createForm(LeagueType::class, $league);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Liga została poprawnie edytowana');

            return $this->redirectToRoute('app.admin.league.dashboard');
        }

        return $this->render('admin/league/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route(
     *     "/{league}/delete",
     *     name="app.admin.league.delete",
     * )
     */
    public function delete(Request $request, League $league): Response
    {
        $this->entityManager->remove($league);
        $this->entityManager->flush();

        $this->addFlash(FlashType::DANGER, 'Liga została usunięta!');

        return $this->redirectToRoute('app.admin.league.dashboard');
    }
}
