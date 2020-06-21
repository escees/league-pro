<?php

namespace App\Controller\Admin;

use App\Dictionary\FlashType;
use App\Entity\Card;
use App\Entity\FootballMatch;
use App\Entity\Goal;
use App\Entity\MatchDetails;
use App\Event\LeagueProEvents;
use App\Event\MatchResultAddedEvent;
use App\Form\MatchDetailsType;
use App\Form\MatchResultType;
use App\Form\MatchStartDateType;
use App\Form\MatchType;
use App\Form\SimpleMatchDetailsType;
use App\Repository\FootballMatchRepository;
use App\Repository\MatchDayRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/match")
 */
class AdminMatchController extends AbstractController
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
    public function dashboard(Request $request, FootballMatchRepository $footballMatchRepository, MatchDayRepository $matchDayRepository): Response
    {
        $form = $this->createForm(MatchType::class, $match = new FootballMatch());

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($match);
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Mecz został poprawnie dodany');

            return $this->redirectToRoute('app.match.dashboard');
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash(FlashType::DANGER, (string) $form->getErrors(true, true));

            return $this->redirectToRoute('app.match.dashboard');
        }

        return $this->render(
            'admin/matches/dashboard.html.twig',
            [
                'matchdays' => $matchDayRepository->findAllOrderByDateDescendant(),
                'fixtures' => $footballMatchRepository->getNumberOfFixturesOrderedByStartDateAscending(16),
                'matches' => $footballMatchRepository->getAllPlayedMatchesOrderedByStartDateDescending(),
                'form' => $form->createView()
            ]
        );
    }

    /**
     * @Route("/{match}/add-result", name="app.match.add_result")
     */
    public function addResult(Request $request, FootballMatch $match): Response
    {
        $form = $this->createForm(MatchResultType::class, $match);

        $matchDetails = $match->getMatchDetails();
        if ($matchDetails instanceof MatchDetails) {
           [$matchGoals, $originalGoals, $matchCards, $originalCards] = $this->getExistingMatchEvents($matchDetails);
        }
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) { //@todo refactor DRY
            if ($matchDetails instanceof MatchDetails) {
                if($matchDetails->hasGoals()) {
                    foreach ($originalGoals as $goal) {
                        if (false === $matchGoals->contains($goal)) {
                            $this->entityManager->remove($goal);
                        }
                    }
                }


                if($matchDetails->hasCards()) {
                    foreach ($originalCards as $card) {
                        if (false === $matchCards->contains($card)) {
                            $this->entityManager->remove($card);
                        }
                    }
                }
            }

            $this->entityManager->persist($match);
            $this->entityManager->flush();

            if (!$match->hasCompleteStats()) {
                $this->eventDispatcher->dispatch(
                    new MatchResultAddedEvent($match),
                    LeagueProEvents::MATCH_RESULT_ADDED

                );
            }

            $this->addFlash(FlashType::SUCCESS, 'Zapisano wynik i szczegóły meczu');

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
            $this->entityManager->persist($match); //@todo probably to remove
            $this->entityManager->flush();

            $this->eventDispatcher->dispatch(
                new MatchResultAddedEvent($match),
                LeagueProEvents::MATCH_RESULT_ADDED

            );

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
     * @Route("/{match}/edit-date", name="app.match.edit_date")
     */
    public function editMatchStartDate(Request $request, FootballMatch $match)
    {
        $form = $this->createForm(MatchStartDateType::class, $match);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->entityManager->persist($match);
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Data rozpoczęcia meczu została zmieniona');

            return $this->redirectToRoute('app.match.dashboard');
        }

        return $this->render(
            'admin/matches/edit_date.html.twig',
            [
                'match' => $match,
                'form' => $form->createView()
            ]
        );
    }

    private function getExistingMatchEvents(MatchDetails $matchDetails): array
    {
        $matchGoals = $matchDetails->getGoals();
        $originalGoals = new ArrayCollection();
        foreach ($matchGoals as $goal) {
            $originalGoals->add($goal);
        }

        $matchCards = $matchDetails->getCards();
        $originalCards = new ArrayCollection();
        foreach ($matchCards as $card) {
            $originalCards->add($card);
        }

        return [$matchGoals, $originalGoals, $matchCards, $originalCards];
    }
}
