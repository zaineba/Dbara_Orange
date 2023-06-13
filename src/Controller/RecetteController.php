<?php

namespace App\Controller;

use App\Entity\DbaraRecette;
use App\Form\DbaraRecetteType;
use App\Repository\DbaraRecetteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

#[Route('/recette')]
class RecetteController extends AbstractController
{
    #[Route('/', name: 'app_recette_index', methods: ['GET'])]
    public function index(DbaraRecetteRepository $dbaraRecetteRepository): Response
    {
        return $this->render('recette/index.html.twig', [
            'dbara_recettes' => $dbaraRecetteRepository->findAll(),
        ]);
    }
    #[Route('/new', name: 'app_recette_new', methods: ['GET', 'POST'])]
    public function new(Request $request, DbaraRecetteRepository $dbaraRecetteRepository, ParameterBagInterface $parameterBag): Response
    {
        $recetteDirectory = $parameterBag->get('recette_directory');
        $dbaraRecette = new DbaraRecette();
        $form = $this->createForm(DbaraRecetteType::class, $dbaraRecette);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $photoFile */
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();

                try {
                    $photoFile->move($recetteDirectory, $newFilename);
                } catch (FileException $e) {
                    // Gérer l'erreur en conséquence
                }

                $dbaraRecette->setPhoto($newFilename);
            }

            $dbaraRecetteRepository->save($dbaraRecette, true);


            return $this->redirectToRoute('app_recette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recette/new.html.twig', [
            'dbara_recette' => $dbaraRecette,
            'form' => $form,
        ]);
    }


    #[Route('/{id}', name: 'app_recette_show', methods: ['GET'])]
    public function show(DbaraRecette $dbaraRecette): Response
    {
        return $this->render('recette/show.html.twig', [
            'dbara_recette' => $dbaraRecette,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_recette_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, DbaraRecette $dbaraRecette, DbaraRecetteRepository $dbaraRecetteRepository): Response
    {
        $form = $this->createForm(DbaraRecetteType::class, $dbaraRecette);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $dbaraRecetteRepository->save($dbaraRecette, true);

            return $this->redirectToRoute('app_recette_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('recette/edit.html.twig', [
            'dbara_recette' => $dbaraRecette,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_recette_delete', methods: ['POST'])]
    public function delete(Request $request, DbaraRecette $dbaraRecette, DbaraRecetteRepository $dbaraRecetteRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $dbaraRecette->getId(), $request->request->get('_token'))) {
            $dbaraRecetteRepository->remove($dbaraRecette, true);
        }

        return $this->redirectToRoute('app_recette_index', [], Response::HTTP_SEE_OTHER);
    }
}
