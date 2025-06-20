<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskForm;
use App\Form\TaskType;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

#[Route('/task')]
class TaskController extends AbstractController


{
    #[Route('/', name: 'app_task_index',methods: ['GET'])]
    public function index(TaskRepository $taskRepository): Response
    {
        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findAll(),
        ]);
    }
    
    #[Route('/new', name: 'app_task_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
    $task = new Task();
    $form = $this->createForm(TaskType::class, $task);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
    $entityManager->persist($task);
    $entityManager->flush();
    $this->addFlash('success', 'Task ajouté avec succès !');
    return $this->redirectToRoute('app_task_index');
    }
    return $this->render('task/new.html.twig', [
    'task' => $task,
    'form' => $form,
    ]);
    }
    
    #[Route('/{id}', name: 'app_task_show', methods: ['GET'])]
    public function show(Task $task): Response
    {
    return $this->render('task/show.html.twig', [
    'task' => $task,
    ]);
    }

    #[Route('/{id}/delete', name: 'app_task_delete', methods: ['POST'])]
    public function delete(Request $request, Task $task, EntityManagerInterface $entityManager): Response
    {
    if ($this->isCsrfTokenValid('delete'.$task->getId(), $request->request->get('_token'))) {
    $entityManager->remove($task);
    $entityManager->flush();
    $this->addFlash('success', 'Task supprimé avec succès !');
    }
    return $this->redirectToRoute('app_task_index');
    }
    
    #[Route('/{id}/edit', name: 'app_task_edit', methods: ['GET', 'POST'])]
    public function edit (Request $request, Task $task, EntityManagerInterface $entityManager) : Response
    { 
    $form = $this->createForm(TaskType::class, $task); 
    $form->handleRequest($request);
    
    if ($form->isSubmitted() && $form->isValid()) { 
        $entityManager->flush();
    $this->addFlash('success','Task modifié avec succès !');
    return $this->redirectToRoute('app_task_index', [], Response::HTTP_SEE_OTHER);
    }
    return $this->render('task/edit.html.twig', [
    'task'=> $task,
    'form'=> $form, ]); }



}