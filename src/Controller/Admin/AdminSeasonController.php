<?php

namespace App\Controller\Admin;

use App\Dictionary\FlashType;
use App\Entity\Season;
use App\Form\SeasonType;
use App\Repository\SeasonRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/season")
 */
class AdminSeasonController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dashboard", name="app.admin.season.dashboard")
     */
    public function dashboard(Request $request, SeasonRepository $seasonRepository): Response
    {
        return $this->render(
            'admin/season/dashboard.html.twig',
            [
                'seasons' => $seasonRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/add", name="app.admin.season.add")
     */
    public function add(Request $request): Response
    {
        $form = $this->createForm(SeasonType::class, $season = new Season());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($season);
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Sezon został poprawnie dodany');

            return $this->redirectToRoute('app.admin.season.dashboard');
        }

        return $this->render('admin/season/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{season}/edit", name="app.admin.season.edit")
     */
    public function edit(Request $request, Season $season): Response
    {
        $form = $this->createForm(SeasonType::class, $season);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Sezon został poprawnie edytowany');

            return $this->redirectToRoute('app.admin.season.dashboard');
        }

        return $this->render('admin/season/edit.html.twig',
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
