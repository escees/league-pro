<?php

namespace App\Controller\Admin;

use App\Dictionary\FlashType;
use App\Entity\FootballMatch;
use App\Entity\MatchDetails;
use App\Form\MatchResultType;
use App\Form\MatchType;
use App\Form\SimpleMatchDetailsType;
use App\Repository\FootballMatchRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

///**
// * @Route("/match-details")
// */
class AdminMatchDetailsController extends AbstractController
{
//    private $entityManager;
//
//    public function __construct(EntityManagerInterface $entityManager)
//    {
//        $this->entityManager = $entityManager;
//    }

//    /**
//     * @Route("/{match}/edit-result", name="app.match.edit_result")
//     */
//    public function editResult(Request $request, FootballMatch $match)
//    {
//        $form = $this->createForm(MatchResultType::class, $match);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $this->entityManager->persist($match);
//            $this->entityManager->flush();
//
////            $this->addFlash(FlashType::SUCCESS, 'Mecz został poprawnie dodany');
//
//            return $this->redirectToRoute('app.match.dashboard');
//        }
//
//        return $this->render(
//            'admin/matches/edit_result.html.twig',
//            [
//                'match' => $match,
//                'form' => $form->createView()
//            ]
//        );
//    }
//
//    /**
//     * @Route(
//     *     "/{match}/score",
//     *     name="app.match.score",
//     *     condition="request.isXmlHttpRequest()"
//     * )
//     */
//    public function setMatchScore(Request $request, FootballMatch $match, FootballMatchRepository $footballMatchRepository)
//    {
//        $form = $this->createForm(SimpleMatchDetailsType::class, $matchDetails = new MatchDetails());
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $match->setMatchDetails($matchDetails);
//            $this->entityManager->persist($matchDetails);
//            $this->entityManager->persist($match);
//            $this->entityManager->flush();
//
////            $this->get('event_dispatcher')->dispatch(
////                ManagerEvents::HARDWARE_REGISTRY_ENTRY_EDITED,
////                new HardwareRegistryEntryEditedEvent($this->getUser(), $employee)
////            );
//
//            $body = $this->renderView(
//                'admin/matches/edit_score.html.twig',
//                [
//                    'matches' => $footballMatchRepository->findAll(),
//                    'form' => $form->createView()
//                ]
//            );
//
//            return new JsonResponse([
//                'status' => true,
//                'body' => $body,
//            ]);
//        }
//
//        return $this->render('admin/matches/_simple_match_details_form.html.twig',
//            [
//                'form' => $form->createView(),
//                'match' => $match,
//            ]
//        );
//    }
}
