<?php

namespace App\Controller;

use App\Repository\GroupRepository;
use App\Repository\TaskRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     */
    public function index(TaskRepository $taskRepository, GroupRepository $groupRepository): Response
    {
       // toutes les les tasks
        $allTasks = $taskRepository->findAll();

        // toutes les tasks avec la deadline asc
        $tasksASC = $taskRepository->findBy([], ['deadline' => 'ASC']);

        // task en fonction de son id (inutile pour l'instant)
        $task = $taskRepository->find(52);
        // nom module de la task
        $module = $task->getModule();
        $moduleName = $module->getName();

        // compter le nombre de tasks
        $countTasks = count($allTasks);
        $taskCount = $taskRepository->getCount(); 

        // task par groupe (ici tp3)
        $tp3 = $groupRepository->findOneBy(['name' => 'TP3', 'semester' => '2']);
        $tp3Task = $tp3->getTasks(); 

        return $this->render('task/index.html.twig', [
            'controller_name' => 'TaskController',
        ]);
    }
}