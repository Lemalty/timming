<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\Group;
use App\Entity\Module;
use App\Entity\Teacher;
use App\Repository\GroupRepository;
use App\Repository\ModuleRepository;
use App\Repository\TeacherRepository;
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
    public function save(EntityManagerInterface $em, Request $request, TeacherRepository $teacherRepository, ModuleRepository $moduleRepository, GroupRepository $groupRepository)
    {
        $task = new Task();
        $deadline = new \DateTime($request->request->get('deadline'));
        // dd($groupRepository->findOneBy(['id' => $request->request->get('group')]));
        // renseigner les informations
        $task->setDescription($request->request->get('description'))
         ->setGroupOfTask($groupRepository->findOneBy(['id' => $request->request->get('group')]))
         ->setDeadline($deadline)
         ->setVisible($request->request->get('visible'))
         ->setTeacher($teacherRepository->findOneBy(['id' => $request->request->get('teacher')]))
         ->setModule($moduleRepository->findOneBy(['id' => $request->request->get('module')]));
        // persister l'entité
        $em->persist($task);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_task_index');
    }

    /**
     * @Route("/backoffice/task/edit/{id}", name="backoffice_task_edit")
     */
    public function edit(EntityManagerInterface $em, $id): Response
    {
        // dd($em->getRepository( Task::class )->find($id));
        return $this->render('backoffice_task/edit.html.twig', [
            'controller_name' => 'BackofficeTaskController',
            'task' => $em->getRepository( Task::class )->find($id),
            'teachers' => $em->getRepository( Teacher::class )->findAll(),
            'groups' => $em->getRepository( Group::class )->findAll(),
            'modules' => $em->getRepository( Module::class )->findAll(),
        ]);
    }

    /**
     * @Route("/backoffice/task/update/{id}", name="backoffice_task_update")
     */
    public function update($id, EntityManagerInterface $em, Request $request, TeacherRepository $teacherRepository, ModuleRepository $moduleRepository, GroupRepository $groupRepository)
    {
        $task = $em->getRepository( Task::class )->find($id);
        $deadline = new \DateTime($request->request->get('deadline'));
        // dd($groupRepository->findOneBy(['id' => $request->request->get('group')]));
        // renseigner les informations
        $task->setDescription($request->request->get('description'))
         ->setGroupOfTask($groupRepository->findOneBy(['id' => $request->request->get('group')]))
         ->setDeadline($deadline)
         ->setVisible($request->request->get('visible'))
         ->setTeacher($teacherRepository->findOneBy(['id' => $request->request->get('teacher')]))
         ->setModule($moduleRepository->findOneBy(['id' => $request->request->get('module')]));
        // persister l'entité
        $em->persist($task);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_task_index');
    }


   /**
     * @Route("/backoffice/task/delete/{id}", name="backoffice_task_delete")
     */
    public function delete(Task $task, EntityManagerInterface $em)
    {
        $em->remove($task);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_task_index');
    }
}