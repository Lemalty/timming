<?php

namespace App\Controller;

use App\Entity\Teacher;
use App\Repository\GroupRepository;
use App\Repository\ModuleRepository;
use App\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BackofficeTeacherController extends AbstractController
{
 /**
     * @Route("/backoffice/teacher", name="backoffice_teacher_index")
     */
    public function index(TeacherRepository $teacherRepository): Response
    {
        return $this->render('backoffice_teacher/index.html.twig', [
            'controller_name' => 'BackofficeTeacherController',
            'teachers' => $teacherRepository->findAll(),
        ]);
    }

    /**
     * @Route("/backoffice/teacher/add", name="backoffice_teacher_add", methods="get")
     */
    public function add(ModuleRepository $moduleRepository): Response
    {
        return $this->render('backoffice_teacher/add.html.twig', [
            'modules' => $moduleRepository->findAll(),
        ]);
    }

    /**
     * Enregistrer un nouvel article.
     * @Route("/backoffice/teacher/add", name="backoffice_teacher_save", methods="post")
     */
    public function save(EntityManagerInterface $em, Request $request, TeacherRepository $teacherRepository, ModuleRepository $moduleRepository, GroupRepository $groupRepository)
    {
        $teacher = new Teacher();
        // renseigner les informations
        // dd($request->request->get('module'));

        $teacher->setName($request->request->get('name'))
         ->addModule($moduleRepository->findOneBy(['id' => $request->request->get('module')]));
        // persister l'entité
        $em->persist($teacher);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_teacher_index');
    }

    // /**
    //  * @Route("/backoffice/task/edit/{id}", name="backoffice_task_edit")
    //  */
    // public function edit(): Response
    // {
    //     return $this->render('backoffice_task/edit.html.twig', [
    //         'controller_name' => 'BackofficeTaskController',
    //     ]);
    // }

    // /**
    //  * @Route("/backoffice/task/update/{id}", name="backoffice_task_update")
    //  */
    // public function update(): Response
    // {
    //     return $this->render('backoffice_task/edit.html.twig', [
    //         'controller_name' => 'BackofficeTaskController',
    //     ]);
    // }
}