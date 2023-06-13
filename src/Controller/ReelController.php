<?php

namespace App\Controller;

use App\Entity\DbaraReel;
use App\Form\DbaraReelType;
use App\Repository\DbaraReelRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


#[Route('/reel')]
class ReelController extends AbstractController
{
    #[Route('/', name: 'app_reel_index', methods: ['GET'])]
    public function index(DbaraReelRepository $dbaraReelRepository): Response
    {
        return $this->render('reel/index.html.twig', [
            'dbara_reels' => $dbaraReelRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_reel_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DbaraReelRepository  $dbaraReelRepository): Response
    {
        $dbaraReel = new DbaraReel();
        $form = $this->createForm(DbaraReelType::class, $dbaraReel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dbaraReelRepository->save($dbaraReel, true);

            return $this->redirectToRoute('app_reel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reel/new.html.twig', [
            'dbara_reel' => $dbaraReel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reel_show', methods: ['GET'])]
    public function show(DbaraReel $dbaraReel): Response
    {
        return $this->render('reel/show.html.twig', [
            'dbara_reel' => $dbaraReel,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_reel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DbaraReel $dbaraReel, DbaraReelRepository  $dbaraReelRepository): Response
    {
        $form = $this->createForm(DbaraReelType::class, $dbaraReel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dbaraReelRepository->save($dbaraReel, true);

            return $this->redirectToRoute('app_reel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('reel/edit.html.twig', [
            'dbara_reel' => $dbaraReel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_reel_delete', methods: ['POST'])]
    public function delete(Request $request, DbaraReel $dbaraReel, DbaraReelRepository  $dbaraReelRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dbaraReel->getId(), $request->request->get('_token'))) {
            $dbaraReelRepository->remove($dbaraReel, true);
        }

        return $this->redirectToRoute('app_reel_index', [], Response::HTTP_SEE_OTHER);
    }
}
