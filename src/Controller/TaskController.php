<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Persistence\ManagerRegistry as PersistenceManagerRegistry;

class TaskController extends AbstractController
{
    /**
     * @Route("/tasks", name="task_list")
     */
    public function listAction(PersistenceManagerRegistry $doctrine)
    {
        return $this->render(
            'task/list.html.twig',
            [
                'tasks' => $doctrine->getRepository(Task::class)->findAll(),
            ],
        );
    }

    /**
     * @Route("/tasks/create", name="task_create")
     */
    public function createAction(Request $request, PersistenceManagerRegistry $doctrine)
    {
        $task = new Task();
        $task->setUser($this->getUser());
        $form = $this->createForm(TaskType::class, $task);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $doctrine->getManager();

            $em->persist($task);
            $em->flush();

            $this->addFlash('success', 'La tâche a été bien été ajoutée.');

            return $this->redirectToRoute('task_list');
        }

        return $this->render('task/create.html.twig', ['form' => $form->createView()]);
    }

    /**
     * @Route("/tasks/{id}/edit", name="task_edit")
     */
    public function editAction(Task $task, Request $request, PersistenceManagerRegistry $doctrine)
    {

        $form = $this->createForm(TaskType::class, $task);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if ($task->getUser() == $this->getUser() || $task->getUser() == null && $this->isGranted('ROLE_ADMIN')) {

                $doctrine->getManager()->flush();
                $this->addFlash('success', 'La tâche a bien été modifiée.');
                return $this->redirectToRoute('task_list');

            } else {

                $this->addFlash('error', 'Vous n\'avez pas les droits pour modifier cette tâche.');
            }
        }

        return $this->render('task/edit.html.twig', [
            'form' => $form->createView(),
            'task' => $task,
        ]);
    }

    /**
     * @Route("/tasks/{id}/toggle", name="task_toggle")
     */
    public function toggleTaskAction(Task $task, PersistenceManagerRegistry $doctrine)
    {
        $task->toggle(!$task->isDone());
        $doctrine->getManager()->flush();

        $this->addFlash('success', sprintf('La tâche %s a bien été marquée comme faite.', $task->getTitle()));

        return $this->redirectToRoute('task_list');
    }

    /**
     * @Route("/tasks/{id}/delete", name="task_delete")
     */
    public function deleteTaskAction(Task $task, PersistenceManagerRegistry $doctrine)
    {
        if ($task->getUser() == $this->getUser() || $task->getUser() == null && $this->isGranted('ROLE_ADMIN')) {

            $em = $doctrine->getManager();
            $em->remove($task);
            $em->flush();
            $this->addFlash('success', 'La tâche a bien été supprimée.');

        } else {

            $this->addFlash('error', 'Vous n\'avez pas les droits pour supprimer cette tâche.');
            
        }

        return $this->redirectToRoute('task_list');
    }
}
