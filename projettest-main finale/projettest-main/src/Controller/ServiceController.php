<?php

namespace App\Controller;

use App\Entity\Service;
use App\Form\ServiceType;
use App\Repository\ServiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

#[Route('/service')]
class ServiceController extends AbstractController
{
    #[Route('/', name: 'app_service_index', methods: ['GET'])]
    public function index(ServiceRepository $serviceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $page = $request->query->getInt('page', 1);
        $pageSize = 3;

        $searchTerm = $request->query->get('search');
        if ($searchTerm) {
            $servicesQuery = $serviceRepository->searchByNameOrCategory($searchTerm);
        } else {
            $servicesQuery = $serviceRepository->findAll();
        }

        $services = $paginator->paginate(
            $servicesQuery,
            $page,
            $pageSize
        );

        return $this->render('service/index.html.twig', [
            'services' => $services,
        ]);
    }
    #[Route('/search', name: 'app_service_search', methods: ['GET'])]
public function search(ServiceRepository $serviceRepository, Request $request): JsonResponse
{
    $searchTerm = $request->query->get('search');
    $services = $serviceRepository->searchByNameOrCategory($searchTerm);

    // You may need to serialize your entities to return them properly
    $data = []; 
    foreach ($services as $service) {
        $data[] = [
            'id' => $service->getId(),
            'name' => $service->getNom(), // Adjust according to your entity structure
            // Add more fields if needed
        ];
    }

    return new JsonResponse($data);
}
    #[Route('/backindex', name: 'app_service_indexback', methods: ['GET'])]
    public function indexback(ServiceRepository $serviceRepository): Response
    {
        return $this->render('service/indexBack.html.twig', [
            'services' => $serviceRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_service_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['image']->getData();
            $fileName = uniqid().'.'.$file->guessExtension();

            // Move the file to the directory where your images are stored
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            // Set the 'image' property with the file name
            $service->setImage($fileName);
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/new.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }

        #[Route('/Bnew', name: 'app_service_newB', methods: ['GET', 'POST'])]
    public function newB(Request $request, EntityManagerInterface $entityManager): Response
    {
        $service = new Service();
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $file = $form['image']->getData();
            $fileName = uniqid().'.'.$file->guessExtension();

            // Move the file to the directory where your images are stored
            $file->move(
                $this->getParameter('image_directory'),
                $fileName
            );

            // Set the 'image' property with the file name
            $service->setImage($fileName);
            $entityManager->persist($service);
            $entityManager->flush();

            return $this->redirectToRoute('app_service_indexback', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('service/addBack.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    } 
    #[Route('/{id}', name: 'app_service_show', methods: ['GET'])]
    public function show(Service $service): Response
    {
        return $this->render('service/show.html.twig', [
            'service' => $service,
        ]);
    }

    #[Route('/back/{id}', name: 'app_service_showback', methods: ['GET'])]
    public function showback(Service $service): Response
    {
        return $this->render('service/showBack.html.twig', [
            'service' => $service,
        ]);
    }
    
    #[Route('/{id}/edit', name: 'app_service_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Get the current image name
            $currentImage = $service->getImage();

            // Get the uploaded file
            $file = $form['image']->getData();

            // Check if a new file was uploaded
            if ($file) {
                // Generate a unique file name
                $fileName = uniqid().'.'.$file->guessExtension();

                // Move the uploaded file to the image directory
                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );

                // Update the image field with the new file name
                $service->setImage($fileName);
            } else {
                // If no new file was uploaded, retain the current image name
                $service->setImage($currentImage);
            }

            // Persist changes to the database
            $entityManager->flush();

            // Redirect to the service index page
            return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
        }

        // If the form is not submitted or is not valid, render the edit form template
        return $this->renderForm('service/edit.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }
    #[Route('/{id}/editB', name: 'app_service_editB', methods: ['GET', 'POST'])]
    public function editB(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ServiceType::class, $service);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Get the uploaded file
            $file = $form['image']->getData();
    
            // Check if a new file was uploaded
            if ($file) {
                // Generate a unique file name
                $fileName = uniqid().'.'.$file->guessExtension();
    
                // Move the uploaded file to the image directory
                $file->move(
                    $this->getParameter('image_directory'),
                    $fileName
                );
    
                // Update the image field with the new file name
                $service->setImage($fileName);
            }
    
            // Persist changes to the database
            $entityManager->flush();
    
            // Redirect to the service index page
            return $this->redirectToRoute('app_service_indexback', [], Response::HTTP_SEE_OTHER);
        }
    
        // If the form is not submitted or is not valid, render the edit form template
        return $this->renderForm('service/editBack.html.twig', [
            'service' => $service,
            'form' => $form,
        ]);
    }
    

    #[Route('/{id}', name: 'app_service_delete', methods: ['POST'])]
    public function delete(Request $request, Service $service, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
            $entityManager->remove($service);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_service_index', [], Response::HTTP_SEE_OTHER);
    }
 #[Route('/B/{id}', name: 'app_service_deleteB', methods: ['POST'])]
public function deleteB(Request $request, Service $service, EntityManagerInterface $entityManager): Response
{
    if ($this->isCsrfTokenValid('delete'.$service->getId(), $request->request->get('_token'))) {
        $entityManager->remove($service);
        $entityManager->flush();
    }

    return $this->redirectToRoute('app_service_indexback', [], Response::HTTP_SEE_OTHER);
}

    #[Route('/sort/aaaaa', name: 'app_service_sort', methods: ['GET'])]
    public function sort(ServiceRepository $serviceRepository, PaginatorInterface $paginator, Request $request): Response
    {
        $sortBy = $request->query->get('sort_by', 'nom');
        $sortOrder = $request->query->get('sort_order', 'ASC');

        $services = $serviceRepository->sortBy($sortBy, $sortOrder);

        return $this->render('service/indexBack.html.twig', [
            'services' => $services,
        ]);
    }
}
