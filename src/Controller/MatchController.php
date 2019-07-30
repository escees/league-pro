<?php

namespace App\Controller;

use App\Dictionary\FlashType;
use App\Entity\Card;
use App\Entity\FootballMatch;
use App\Entity\Goal;
use App\Entity\MatchDetails;
use App\Form\MatchDetailsType;
use App\Form\MatchResultType;
use App\Form\MatchType;
use App\Form\SimpleMatchDetailsType;
use App\Repository\FootballMatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/match")
 */
class MatchController extends AbstractController
{
    private $entityManager;
    private $eventDispatcher;

    public function __construct(
        EntityManagerInterface $entityManager,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->entityManager = $entityManager;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @Route("/dashboard", name="app.match.dashboard")
     */
    public function dashboard(Request $request, FootballMatchRepository $footballMatchRepository): Response
    {
        $form = $this->createForm(MatchType::class, $match = new FootballMatch());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($match);
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Mecz został poprawnie dodany');

            return $this->redirectToRoute('app.match.dashboard');
        }

        return $this->render(
            'admin/matches/dashboard.html.twig',
            [
                'matches' => $footballMatchRepository->findAll(),
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{match}/edit-result", name="app.match.edit_result")
     */
    public function editResult(Request $request, FootballMatch $match): Response
    {
        $form = $this->createForm(MatchResultType::class, $match);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Zapisano szczegóły meczu');

            return $this->redirectToRoute('app.match.dashboard');
        }

        return $this->render(
            'admin/matches/result.html.twig',
            [
                'match' => $match,
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route(
     *     "/{match}/score",
     *     name="app.match.score",
     *     condition="request.isXmlHttpRequest()"
     * )
     */
    public function setMatchScore(Request $request, FootballMatch $match, FootballMatchRepository $footballMatchRepository): Response
    {
        $form = $this->createForm(SimpleMatchDetailsType::class, $matchDetails = new MatchDetails());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $match->setMatchDetails($matchDetails);
            $this->entityManager->persist($matchDetails);
            $this->entityManager->persist($match);
            $this->entityManager->flush();

            $body = $this->renderView(
                'admin/matches/edit_score.html.twig',
                [
                    'matches' => $footballMatchRepository->findAll(),
                    'form' => $form->createView()
                ]
            );

            return new JsonResponse([
                'status' => true,
                'body' => $body,
            ]);
        }

        return $this->render('admin/matches/_simple_match_details_form.html.twig',
            [
                'form' => $form->createView(),
                'match' => $match,
            ]
        );
    }

    /**
     * @Route(
     *     "/{match}/details/add-scorer",
     *     name="app.match.scorer.add",
     *     condition="request.isXmlHttpRequest()"
     * )
     */
    public function addScorer(Request $request, FootballMatch $match): JsonResponse
    {
        return $this->addMatchEvent($request, new Goal(), $match);
    }

    /**
     * @Route(
     *     "/{match}/details/add-card",
     *     name="app.match.card.add",
     *     condition="request.isXmlHttpRequest()"
     * )
     */
    public function addCard(Request $request, FootballMatch $match): JsonResponse
    {
        return $this->addMatchEvent($request, new Card(), $match);
    }

    private function addMatchEvent(Request $request, object $matchEvent, FootballMatch $match): JsonResponse
    {
        $form = $this->createForm(MatchDetailsType::class, $matchDetails = new MatchDetailsType());
        $form->handleRequest($request);

        /** @var MatchDetails $matchDetails */
        $matchDetails = $form->getData();
        if($matchEvent instanceof Goal) {
            $matchDetails->addGoal($matchEvent);
        }
        if($matchEvent instanceof Card) {
            $matchDetails->addCard($matchEvent);
        }

        $form = $this->createForm(MatchDetailsType::class, $matchDetails);

        $body = $this->renderView(
            'admin/matches/edit_result.html.twig',
            [
                'match' => $match,
                'form' => $form->createView()
            ]
        );

        return new JsonResponse([
            'status' => true,
            'body' => $body,
        ]);
    }

}
