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
     * @Route("/home/{year}/{tpEtu}", name="tp", requirements={"year"="1|2", "tpEtu"="1|2|3|4"})
     */
    public function tp(TaskRepository $taskRepository, GroupRepository $groupRepository, $year, $tpEtu): Response
    {
        //Vérification de l'année d'études
        if($year == 1){
            //Récupération des taches du TP demandé
            $tp = $groupRepository->findOneBy(['name' => 'TP'.$tpEtu, 'semester' => '2']);
            $tpTask = $tp->getTasks(); 
            // dd($tpTask);
            //Vérification du Tp demandé
            if($tpEtu==1||$tpEtu==2)
            {
                //Récupération des taches du TD demandé
                $td = $groupRepository->findOneBy(['name' => 'TDA', 'semester' => '2']);
                $tdTask = $td->getTasks();
            }
            else if($tpEtu==3||$tpEtu==4)
            {
                $td = $groupRepository->findOneBy(['name' => 'TDB', 'semester' => '2']);
                $tdTask = $td->getTasks();
            }
            else{
                dd("error");
            }           
            
            //Récupération des taches de la promotion de première année
            $cm = $groupRepository->findOneBy(['name' => 'CM', 'semester' => '2']);
            $cmTask = $cm->getTasks();   

        }
        
        else{
            if($year == 2){
                 //Récupération des taches du TP demandé
            $tp = $groupRepository->findOneBy(['name' => 'TP'.$tpEtu, 'semester' => '4']);
            $tpTask = $tp->getTasks(); 
            //Vérification du Tp demandé
            if($tpEtu==1||$tpEtu==2)
            {
                //Récupération des taches du TD demandé
                $td = $groupRepository->findOneBy(['name' => 'TDA', 'semester' => '4']);
                $tdTask = $td->getTasks();
            }
            else if($tpEtu==3||$tpEtu==4)
            {
                $td = $groupRepository->findOneBy(['name' => 'TDB', 'semester' => '4']);
                $tdTask = $td->getTasks();
            }
            else{
                dd("error");
            }           
            
            //Récupération des taches de la promotion de deuxième année
            $cm = $groupRepository->findOneBy(['name' => 'CM', 'semester' => '4']);
            $cmTask = $cm->getTasks();     
               
            }
        }
        return $this->render('task/test.html.twig', [
            'TPs' => $tpTask,
            'TDs' => $tdTask,
            'CMs' => $cmTask,
        ]);       
    }    
}