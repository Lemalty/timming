<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Group;
use App\Entity\Module;
use App\Entity\Teacher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackofficeTaskController extends AbstractController
{
    /**
     * @Route("/backoffice/task", name="backoffice_task_index")
     */
    public function index(EntityManagerInterface $em): Response
    {
        // dd($em->getRepository( Task::class )->findDetailled());
        return $this->render('backoffice_task/index.html.twig', [
            'controller_name' => 'BackofficeTaskController',
            'tasks' => $em->getRepository( Task::class )->findAll(),
        ]);
    }

    /**
     * @Route("/backoffice/task/add", name="backoffice_task_add", methods="get")
     */
    public function add(EntityManagerInterface $em): Response
    {
        return $this->render('backoffice_task/add.html.twig', [
            'controller_name' => 'BackofficeTaskController',
            'teachers' => $em->getRepository( Teacher::class )->findAll(),
            'groups' => $em->getRepository( Group::class )->findAll(),
            'modules' => $em->getRepository( Module::class )->findAll(),
        ]);
    }

    /**
     * Enregistrer un nouvel article.
     * @Route("/backoffice/task/add", name="backoffice_task_save", methods="post")
     */
    public function save(EntityManagerInterface $em, Request $request)
    {
        // dd($request->request);
        $task = new Task();
        // renseigner les informations
        $task->setDescription($request->request->get('description'))
         ->setGroupOfTask($request->request->get('groupOfTask'))
         ->setDeadline($request->request->get('deadline'))
         ->setTeacher($request->request->get('teacher'))
         ->setModule($request->request->get('module'));
        // persister l'entité
        $em->persist($task);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('post_index');
    }

    /**
     * @Route("/backoffice/task/edit/{id}", name="backoffice_task_edit")
     */
    public function edit(): Response
    {
        return $this->render('backoffice_task/edit.html.twig', [
            'controller_name' => 'BackofficeTaskController',
        ]);
    }

    /**
     * @Route("/backoffice/task/update/{id}", name="backoffice_task_update")
     */
    public function update(): Response
    {
        return $this->render('backoffice_task/edit.html.twig', [
            'controller_name' => 'BackofficeTaskController',
        ]);
    }
}