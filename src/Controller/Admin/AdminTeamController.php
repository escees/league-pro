<?php

namespace App\Controller\Admin;

use App\Dictionary\FlashType;
use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\LeagueRepository;
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
     * @Route("/list", name="app.team.list")
     */
    public function dashboard(Request $request, TeamRepository $teamRepository, LeagueRepository $leagueRepository): Response
    {
        return $this->render(
            'admin/team/list.html.twig',
            [
                'teams' => $teamRepository->getAllTeamsWithoutLeague(),
                'leagues' => $leagueRepository->findAll()
            ]
        );
    }

    /**
     * @Route(
     *     "/add",
     *     name="app.team.add",
     *     condition="request.isXmlHttpRequest()"
     * )
     */
    public function addTeam(Request $request, TeamRepository $teamRepository, LeagueRepository $leagueRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team = new Team());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($team);
            $this->entityManager->flush();

            $body = $this->renderView(
                'admin/team/list_content.html.twig',
                [
                    'teams' => $teamRepository->getAllTeamsWithoutLeague(),
                    'leagues' => $leagueRepository->findAll()                ]
            );

            return new JsonResponse([
                'status' => true,
                'body' => $body,
            ]);
        }

        return $this->render('admin/team/view.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route(
     *     "/{team}/edit",
     *     name="app.team.edit",
     *     condition="request.isXmlHttpRequest()"
     * )
     */
    public function editTeam(Request $request, Team $team, TeamRepository $teamRepository, LeagueRepository $leagueRepository): Response
    {
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $body = $this->renderView(
                'admin/team/list_content.html.twig',
                [
                    'teams' => $teamRepository->getAllTeamsWithoutLeague(),
                    'leagues' => $leagueRepository->findAll()
                ]
            );

            return new JsonResponse([
                'status' => true,
                'body' => $body,
            ]);
        }

        return $this->render('admin/team/view.html.twig',
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
    public function delete(Request $request, Team $team, TeamRepository $teamRepository): Response
    {
        $this->entityManager->remove($team);
        $this->entityManager->flush();

        $this->addFlash(FlashType::DANGER, 'Drużyna została usunięta!');

        return $this->render('admin/team/list.html.twig',
            [
                'teams' => $teamRepository->findAll(),
            ]
        );
    }
}
