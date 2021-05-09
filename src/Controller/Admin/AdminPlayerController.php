<?php

namespace App\Controller\Admin;

use App\Dictionary\FlashType;
use App\Entity\Player;
use App\Factory\PlayerFactory;
use App\Form\PlayerImportType;
use App\Form\PlayerType;
use App\Repository\PlayerRepository;
use App\Repository\TeamRepository;
use App\Service\Import\Csv\PlayerCsvImporter;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use League\Csv\Reader;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/player")
 */
class AdminPlayerController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/list", name="app.admin.player.list")
     */
    public function dashboard(Request $request, PlayerRepository $playerRepository, TeamRepository $teamRepository): Response
    {
        return $this->render(
            'admin/player/list.html.twig',
            [
                'players' => $playerRepository->findAll(),
                'teams' => $teamRepository->findAll(),
            ]
        );
    }

    /**
     * @Route(
     *     "/add",
     *     name="app.player.add"
     * )
     */
    public function addPlayer(Request $request, TeamRepository $teamRepository): Response
    {
        $form = $this->createForm(PlayerType::class, $player = new Player());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($player);
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Zawodnik został poprawnie dodany');

            return $this->redirectToRoute('app.admin.player.list');
        }

        return $this->render('admin/player/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route(
     *     "/{player}/edit",
     *     name="app.player.edit"
     * )
     */
    public function editPlayer(Request $request, Player $player): Response
    {
        $form = $this->createForm(PlayerType::class, $player);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Zawodnik został poprawnie edytowany');

            return $this->redirectToRoute('app.admin.player.list');
        }

        return $this->render('admin/player/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route(
     *     "/{player}/delete",
     *     name="app.player.delete",
     * )
     */
    public function delete(Request $request, Player $player, TeamRepository $teamRepository): Response
    {
        $this->entityManager->remove($player);
        $this->entityManager->flush();

        $this->addFlash(FlashType::DANGER, 'Zawodnik został usunięty!');

        return $this->render('admin/player/list.html.twig',
            [
                'teams' => $teamRepository->findAll(),
            ]
        );
    }

    /**
     * @Route(
     *     "/import",
     *     name="app.player.import.csv",
     * )
     */
    public function import(Request $request, PlayerCsvImporter $playerImporter)
    {
        $form = $this->createForm(PlayerImportType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $file = $form->get('playerFile')->getData();
            $playerImporter->import($file, $form->getData()['team']);

            $this->addFlash(FlashType::SUCCESS, sprintf('Zawodnicy zostali poprawnie zaimportowani do drużyny %s', $form->getData()['team']->getName()));

            return $this->redirectToRoute('app.admin.player.list');
        }

        return $this->render('admin/player/import.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
