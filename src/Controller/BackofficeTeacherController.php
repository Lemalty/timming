<?php

namespace App\Controller;

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
    public function save(EntityManagerInterface $em, Request $request, ModuleRepository $moduleRepository)
    {
        $teacher = new Teacher();
        // renseigner les informations
        $teacher->setName($request->request->get('name'));

        $newModule = $request->request->get('module');
        $newModule = $moduleRepository->findOneBy(['id' => $newModule]);

        $error = false;

            foreach($teacher->getModules() as $module) {
                $error = false;
            
                if($module->getName() === $newModule->getName()) {
                    $error = true;
                    break;
                }
            }

        if($error === false) {
        $teacher->addModule($newModule);
        }


        // persister l'entité
        $em->persist($teacher);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_teacher_index');
    }

    /**
     * @Route("/backoffice/teacher/edit/{id}", name="backoffice_teacher_edit")
     */
    public function edit(EntityManagerInterface $em, $id, ModuleRepository $moduleRepository): Response
    {
        if($id==null ||$em->getRepository( Teacher::class )->find($id) == null) {
            return $this->redirectToRoute('backoffice_teacher_index');
        }
        else {
        return $this->render('backoffice_teacher/edit.html.twig', [
            'teacher' => $em->getRepository( Teacher::class )->find($id),
            'modules' => $moduleRepository->findAll(),
        ]);
        }
    }

    /**
     * @Route("/backoffice/teacher/update/{id}", name="backoffice_teacher_update")
     */
    public function update(EntityManagerInterface $em, Request $request, ModuleRepository $moduleRepository, TeacherRepository $teacherRepository, $id): Response
    {

        if($id==null ||$teacherRepository->find($id) == null) {
            return $this->redirectToRoute('backoffice_teacher_index');
        }

        else{
            $teacher = new Teacher();

            $teacher = $teacherRepository->find($id);
            // renseigner les informations
            $teacher->setName($request->request->get('name'));
            
            $newModule = $request->request->get('module');
            $newModule = $moduleRepository->findOneBy(['id' => $newModule]);

            $error = false;

                foreach($teacher->getModules() as $module) {
                    $error = false;
                
                    if($module->getName() === $newModule->getName()) {
                        $error = true;
                        break;
                    }
                }

            if($error === false) {
            $teacher->addModule($newModule);
            }

            
            // persister l'entité
            $em->persist($teacher);
            // déclencher le traitements SQL
            $em->flush();
            // redirection
            return $this->redirectToRoute('backoffice_teacher_index');
        }
    }


        

    /**
     * @Route("/backoffice/teacher/delete/{id}", name="backoffice_teacher_delete")
     */
    public function delete(TeacherRepository $teacherRepository, EntityManagerInterface $em, $id): Response
    {
        if($id==null ||$teacherRepository->find($id) == null) {
            return $this->redirectToRoute('backoffice_teacher_index');
        }
        
        else {
            $deleteItem = $teacherRepository->find($id);
            
            $em->remove($deleteItem);
            $em->flush();
            return $this->redirectToRoute('backoffice_teacher_index');
        }
    }
}