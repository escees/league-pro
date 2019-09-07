<?php

namespace App\Controller\Admin;

use App\Dictionary\FlashType;
use App\Entity\MatchDay;
use App\Entity\Season;
use App\Form\MatchDayType;
use App\Form\SeasonType;
use App\Repository\MatchDayRepository;
use App\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/matchday")
 */
class AdminMatchDayController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dashboard", name="app.admin.matchday.dashboard")
     */
    public function dashboard(Request $request, MatchDayRepository $matchDayRepository): Response
    {
        return $this->render(
            'admin/matchday/dashboard.html.twig',
            [
                'matchdays' => $matchDayRepository->findAllOrderByDateDescendant(),
            ]
        );
    }

    /**
     * @Route("/add", name="app.admin.matchday.add")
     */
    public function add(Request $request): Response
    {
        $form = $this->createForm(MatchDayType::class, $matchday = new MatchDay());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($matchday);
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Kolejka została poprawnie dodana');

            return $this->redirectToRoute('app.admin.matchday.dashboard');
        }

        return $this->render('admin/matchday/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{matchDay}/edit", name="app.admin.matchday.edit")
     */
    public function edit(Request $request, MatchDay $matchDay): Response
    {
        $form = $this->createForm(MatchDayType::class, $matchDay);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Kolejka została poprawnie edytowana');

            return $this->redirectToRoute('app.admin.matchday.dashboard');
        }

        return $this->render('admin/matchday/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route(
     *     "/{season}/delete",
     *     name="app.admin.season.delete",
     * )
     */
    public function delete(Request $request, Season $season): Response
    {
        $this->entityManager->remove($season);
        $this->entityManager->flush();

        $this->addFlash(FlashType::DANGER, 'Sezon został usunięty!');

        return $this->redirectToRoute('app.admin.season.dashboard');
    }
}
