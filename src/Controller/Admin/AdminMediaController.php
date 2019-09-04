<?php

namespace App\Controller\Admin;

use App\Dictionary\FlashType;
use App\Entity\Media;
use App\Form\MediaType;
use App\Repository\MediaRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/media/")
 */
class AdminMediaController extends AbstractController
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @Route("/dashboard", name="app.admin.media.list")
     */
    public function dashboard(Request $request, MediaRepository $mediaRepository): Response
    {
        return $this->render(
            'admin/media/dashboard.html.twig',
            [
                'mediaFiles' => $mediaRepository->findAll(),
            ]
        );
    }

    /**
     * @Route("/add", name="app.admin.media.add")
     */
    public function add(Request $request): Response
    {
        $form = $this->createForm(MediaType::class, $media = new Media());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($media);
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Plik został poprawnie dodany');

            return $this->redirectToRoute('app.admin.media.list');
        }

        return $this->render('admin/media/add.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }

    /**
     * @Route("/{media}/edit", name="app.admin.media.edit")
     */
    public function edit(Request $request, Media $media): Response
    {
        $form = $this->createForm(MediaType::class, $media);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->flush();

            $this->addFlash(FlashType::SUCCESS, 'Plik został poprawnie załadowany');

            return $this->redirectToRoute('app.admin.media.list');
        }

        return $this->render('admin/media/edit.html.twig',
            [
                'form' => $form->createView(),
            ]
        );
    }
}
