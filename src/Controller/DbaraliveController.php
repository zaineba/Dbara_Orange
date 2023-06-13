<?php

namespace App\Controller;

use App\Entity\DbaraLive;
use App\Form\DbaraLiveType;
use App\Repository\DbaraLiveRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/dbaralive')]
class DbaraliveController extends AbstractController
{
    #[Route('/', name: 'app_dbaralive_index', methods: ['GET'])]
    public function index(DbaraLiveRepository $dbaraLiveRepository): Response
    {
        return $this->render('dbaralive/index.html.twig', [
            'dbara_lives' => $dbaraLiveRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_dbaralive_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DbaraLiveRepository $dbaraLiveRepository): Response
    {
        $dbaraLive = new DbaraLive();
        $form = $this->createForm(DbaraLiveType::class, $dbaraLive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dbaraLiveRepository->save($dbaraLive, true);

            return $this->redirectToRoute('app_dbaralive_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dbaralive/new.html.twig', [
            'dbara_live' => $dbaraLive,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dbaralive_show', methods: ['GET'])]
    public function show(DbaraLive $dbaraLive): Response
    {
        return $this->render('dbaralive/show.html.twig', [
            'dbara_live' => $dbaraLive,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_dbaralive_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DbaraLive $dbaraLive, DbaraLiveRepository $dbaraLiveRepository): Response
    {
        $form = $this->createForm(DbaraLiveType::class, $dbaraLive);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dbaraLiveRepository->save($dbaraLive, true);

            return $this->redirectToRoute('app_dbaralive_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dbaralive/edit.html.twig', [
            'dbara_live' => $dbaraLive,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_dbaralive_delete', methods: ['POST'])]
    public function delete(Request $request, DbaraLive $dbaraLive, DbaraLiveRepository $dbaraLiveRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$dbaraLive->getId(), $request->request->get('_token'))) {
            $dbaraLiveRepository->remove($dbaraLive, true);
        }

        return $this->redirectToRoute('app_dbaralive_index', [], Response::HTTP_SEE_OTHER);
    }
}
