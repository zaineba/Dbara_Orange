<?php

namespace App\Controller;

use App\Entity\Chef;
use App\Form\ChefType;
use App\Repository\ChefRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;


#[Route('/chef')]
class ChefController extends AbstractController
{
    #[Route('/', name: 'app_chef_index', methods: ['GET'])]
    public function index(ChefRepository $chefRepository): Response
    {
        return $this->render('chef/index.html.twig', [
            'chefs' => $chefRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_chef_new', methods: ['GET', 'POST'])]

    public function new(Request $request, ChefRepository $chefRepository, ParameterBagInterface $parameterBag): Response
    {
        $photoDirectory = $parameterBag->get('photo_directory');
        $chef = new Chef();
        $form = $this->createForm(ChefType::class, $chef);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var UploadedFile|null $photoFile */
            $photoFile = $form->get('photo')->getData();

            if ($photoFile) {
                $newFilename = uniqid() . '.' . $photoFile->guessExtension();

                try {
                    $photoFile->move($photoDirectory, $newFilename);
                } catch (FileException $e) {
                    // Gérer l'erreur en conséquence
                }

                $chef->setPhoto($newFilename);
            }

            $chefRepository->save($chef, true);

            return $this->redirectToRoute('app_chef_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('chef/new.html.twig', [
            'chef' => $chef,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_chef_show', methods: ['GET'])]
    public function show(Chef $chef): Response
    {
        return $this->render('chef/show.html.twig', [
            'chef' => $chef,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_chef_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Chef $chef, ChefRepository $chefRepository, ParameterBagInterface $parameterBag): Response
    {
        $form = $this->createForm(ChefType::class, $chef);
        $form->handleRequest($request);
        $photoDirectory = $parameterBag->get('photo_directory');

        if ($form->isSubmitted() && $form->isValid()) {
            // Gérer l'upload de l'image
            $photoFile = $form->get('photo')->getData();
            if ($photoFile) {
                $originalFilename = pathinfo($photoFile->getClientOriginalName(), PATHINFO_FILENAME);
                $newFilename = $originalFilename . '-' . uniqid() . '.' . $photoFile->guessExtension();

                // Déplacer le fichier dans le répertoire des photos
                $photoFile->move($photoDirectory, $newFilename);

                // Mettre à jour le nom du fichier dans l'entité Chef
                $chef->setPhoto($newFilename);
            }

            // Enregistrer les modifications du chef
            $chefRepository->save($chef, true);

            return $this->redirectToRoute('app_chef_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('chef/edit.html.twig', [
            'chef' => $chef,
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id}', name: 'app_chef_delete', methods: ['POST'])]
    public function delete(Request $request, Chef $chef, ChefRepository $chefRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $chef->getId(), $request->request->get('_token'))) {
            $chefRepository->remove($chef, true);
        }

        return $this->redirectToRoute('app_chef_index', [], Response::HTTP_SEE_OTHER);
    }
}
