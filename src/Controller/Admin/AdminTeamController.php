<?php

namespace App\Controller\Admin;

use App\Dictionary\FlashType;
use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\LeagueRepository;
use App\Repository\SeasonRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/team")
 */
class AdminTeamController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/list", name="app.admin.team.list")
     */
    public function dashboard(Request $request, TeamRepository $teamRepository, SeasonRepository $seasonRepository): Response
    {
        return $this->render(
            'admin/team/list.html.twig',
            [
                'teams' => $teamRepository->getAllTeamsWithoutLeague(),
                'seasons' => $seasonRepository->findAll()
            ]
        );
    }

    /**
     * @Route(
     *     "/add",
     *     name="app.admin.team.add"
     * )
     */
    public function addTeam(Request $request, TeamRepository $teamRepository, SeasonRepository $seasonRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team = new Team());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($team);
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Drużyna została poprawnie dodana');

            return $this->redirectToRoute('app.admin.team.list');
        }

        return $this->render('admin/team/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route(
     *     "/{team}/edit",
     *     name="app.team.edit",
     * )
     */
    public function editTeam(Request $request, Team $team, TeamRepository $teamRepository, SeasonRepository $seasonRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Drużyna została poprawnie edytowana');

            return $this->redirectToRoute('app.admin.team.list');
        }

        return $this->render('admin/team/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route(
     *     "/{team}/delete",
     *     name="app.team.delete",
     * )
     */
    public function delete(Request $request, Team $team, TeamRepository $teamRepository, SeasonRepository $seasonRepository): Response
    {
        if (!$team->canBeDeleted()) {
            $this->addFlash(FlashType::DANGER, 'Drużyna nie może zostać usunięta ponieważ rozegrała lub ma do rozegrania mecze!');

            return $this->redirectToRoute('app.admin.team.list');
        }
        $this->entityManager->remove($team);
        $this->entityManager->flush();

        $this->addFlash(FlashType::SUCCESS, 'Drużyna została usunięta!');

        return $this->redirectToRoute('app.admin.team.list');
    }
}
