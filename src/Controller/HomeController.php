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


        /**/
        $groupe = $task->getGroupOfTask();
        $groupeName = $groupe->getName();
        $groupeS = $groupe->getSemester();

        // compter le nombre de tasks
        $countTasks = count($allTasks);
        $taskCount = $taskRepository->getCount(); 

        // task par groupe (ici tp3)
        $tp3 = $groupRepository->findOneBy(['name' => 'TP3', 'semester' => '2']);
        $tp3Task = $tp3->getTasks(); 

        return $this->render('task/index.html.twig', [
            'tasks' => $taskRepository->findBy([], ['deadline' => 'ASC']),
        ]);
    }

    /**
     * @Route("/home/{year}/tp1", name="tp1")
     */
    public function tp1(TaskRepository $taskRepository, GroupRepository $groupRepository, $year): Response
    {
        if($year === 'mmi1'){
            $tp1 = $groupRepository->findOneBy(['name' => 'TP1', 'semester' => '2']);
            $tp1Task = $tp1->getTasks(); 
            $tda = $groupRepository->findOneBy(['name' => 'TDA', 'semester' => '2']);
            $tdaTask = $tda->getTasks();
            $cm = $groupRepository->findOneBy(['name' => 'CM', 'semester' => '2']);
            $cmTask = $cm->getTasks(); 
        
            return $this->render('task/test.html.twig', [
                'TPs' => $tp1Task,
                'TDs' => $tdaTask,
                'CMs' => $cmTask,
            ]);
        }else{
            if($year === 'mmi2'){
                $tp1 = $groupRepository->findOneBy(['name' => 'TP1', 'semester' => '4']);
                $tp1Task = $tp1->getTasks(); 
                $tda = $groupRepository->findOneBy(['name' => 'TDA', 'semester' => '4']);
                $tdaTask = $tda->getTasks();
                $cm = $groupRepository->findOneBy(['name' => 'CM', 'semester' => '4']);
                $cmTask = $cm->getTasks(); 
            
                return $this->render('task/test.html.twig', [
                    'TPs' => $tp1Task,
                    'TDs' => $tdaTask,
                    'CMs' => $cmTask,
                ]);
            }
        }
        
    }
    /**
     * @Route("/home/{year}/tp2", name="tp2")
     */
    public function tp2(TaskRepository $taskRepository, GroupRepository $groupRepository, $year): Response
    {
        if($year === 'mmi1'){
            $tp2 = $groupRepository->findOneBy(['name' => 'TP2', 'semester' => '2']);
            $tp2Task = $tp2->getTasks(); 
            $tda = $groupRepository->findOneBy(['name' => 'TDA', 'semester' => '2']);
            $tdaTask = $tda->getTasks();
            $cm = $groupRepository->findOneBy(['name' => 'CM', 'semester' => '2']);
            $cmTask = $cm->getTasks(); 
        
            return $this->render('task/test.html.twig', [
                'TPs' => $tp2Task,
                'TDs' => $tdaTask,
                'CMs' => $cmTask,
            ]);
        }else{
            if($year === 'mmi2'){
                $tp2 = $groupRepository->findOneBy(['name' => 'TP2', 'semester' => '4']);
                $tp2Task = $tp2->getTasks(); 
                $tda = $groupRepository->findOneBy(['name' => 'TDA', 'semester' => '4']);
                $tdaTask = $tda->getTasks();
                $cm = $groupRepository->findOneBy(['name' => 'CM', 'semester' => '4']);
                $cmTask = $cm->getTasks(); 
            
                return $this->render('task/test.html.twig', [
                    'TPs' => $tp2Task,
                    'TDs' => $tdaTask,
                    'CMs' => $cmTask,
                ]);
            }
        }
    }
    /**
     * @Route("/home/{year}/tp3", name="tp3")
     */
    public function tp3(TaskRepository $taskRepository, GroupRepository $groupRepository, $year): Response
    {
        if($year === 'mmi1'){
            $tp3 = $groupRepository->findOneBy(['name' => 'TP3', 'semester' => '2']);
            $tp3Task = $tp3->getTasks(); 
            $tdb = $groupRepository->findOneBy(['name' => 'TDB', 'semester' => '2']);
            $tdbTask = $tdb->getTasks();
            $cm = $groupRepository->findOneBy(['name' => 'CM', 'semester' => '2']);
            $cmTask = $cm->getTasks(); 
        
            return $this->render('task/test.html.twig', [
                'TPs' => $tp3Task,
                'TDs' => $tdbTask,
                'CMs' => $cmTask,
            ]);
        }else{
            if($year === 'mmi2'){
                $tp3 = $groupRepository->findOneBy(['name' => 'TP3', 'semester' => '4']);
                $tp3Task = $tp3->getTasks(); 
                $tdb = $groupRepository->findOneBy(['name' => 'TDB', 'semester' => '4']);
                $tdbTask = $tdb->getTasks();
                $cm = $groupRepository->findOneBy(['name' => 'CM', 'semester' => '4']);
                $cmTask = $cm->getTasks(); 
            
                return $this->render('task/test.html.twig', [
                    'TPs' => $tp3Task,
                    'TDs' => $tdbTask,
                    'CMs' => $cmTask,
                ]);
            }
        }
    }
    /**
     * @Route("/home/{year}/tp4", name="tp4")
     */
    public function tp4(TaskRepository $taskRepository, GroupRepository $groupRepository, $year): Response
    {
        if($year === 'mmi1'){
            $tp4 = $groupRepository->findOneBy(['name' => 'TP4', 'semester' => '2']);
            $tp4Task = $tp4->getTasks(); 
            $tdb = $groupRepository->findOneBy(['name' => 'TDB', 'semester' => '2']);
            $tdbTask = $tdb->getTasks();
            $cm = $groupRepository->findOneBy(['name' => 'CM', 'semester' => '2']);
            $cmTask = $cm->getTasks(); 
        
            return $this->render('task/test.html.twig', [
                'TPs' => $tp4Task,
                'TDs' => $tdbTask,
                'CMs' => $cmTask,
            ]);
        }else{
            if($year === 'mmi2'){
                $tp4 = $groupRepository->findOneBy(['name' => 'TP4', 'semester' => '4']);
                $tp4Task = $tp4->getTasks(); 
                $tdb = $groupRepository->findOneBy(['name' => 'TDB', 'semester' => '4']);
                $tdbTask = $tdb->getTasks();
                $cm = $groupRepository->findOneBy(['name' => 'CM', 'semester' => '4']);
                $cmTask = $cm->getTasks(); 
            
                return $this->render('task/test.html.twig', [
                    'TPs' => $tp4Task,
                    'TDs' => $tdbTask,
                    'CMs' => $cmTask,
                ]);
            }
        }
    }
}