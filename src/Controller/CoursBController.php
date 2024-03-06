<?php

namespace App\Controller;
use App\Entity\Cours;
use App\Form\Cours1Type;
use App\Repository\CoursRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse; // Add this line to import JsonResponse
use Twig\Environment;


#[Route('/coursb')]
class CoursbController extends AbstractController
{
    #[Route('/', name: 'app_coursb_index', methods: ['GET'])]
    public function index(CoursRepository $coursRepository): Response
    {
        return $this->render('coursb/index.html.twig', [
            'cours' => $coursRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_coursb_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $cour = new Cours();
        $form = $this->createForm(Cours1Type::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($cour);
            $entityManager->flush();

            return $this->redirectToRoute('app_coursb_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('coursb/new.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coursb_show', methods: ['GET'])]
    public function show(Cours $cour): Response
    {
        return $this->render('coursb/show.html.twig', [
            'cour' => $cour,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_coursb_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Cours1Type::class, $cour);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_coursb_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('coursb/edit.html.twig', [
            'cour' => $cour,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_coursb_delete', methods: ['POST'])]
    public function delete(Request $request, Cours $cour, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$cour->getId(), $request->request->get('_token'))) {
            $entityManager->remove($cour);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_coursb_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/search', name: 'app_search_cours', methods: ['GET'])]
    public function search(Request $request, CoursRepository $CoursRepository): JsonResponse
    {
        $query = $request->query->get('q');
        $results = $CoursRepository->findBySearchQuery($query); // Implement findBySearchQuery method in your repository

        $formattedResults = [];
        foreach ($results as $result) {
            // Format results as needed
            $formattedResults[] = [
                'titre' => $result->getTitre(),
                'categorie' => $result->getCategorie(),

                // Add other fields as needed
            ];
        }

        return new JsonResponse($formattedResults);
    }
   
}
