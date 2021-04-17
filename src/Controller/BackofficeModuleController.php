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

class BackofficeModuleController extends AbstractController
{
     /**
     * @Route("/backoffice/modules", name="backoffice_module_index")
     */
    public function index(ModuleRepository $moduleRepository): Response
    {
        return $this->render('backoffice_module/index.html.twig', [
            'modules' => $moduleRepository->findAll(),
        ]);
    }

    /**
     * @Route("/backoffice/module/add", name="backoffice_module_add", methods="get")
     */
    public function add(TeacherRepository $teacherRepository): Response
    {
        return $this->render('backoffice_module/add.html.twig', [
            'teachers' => $teacherRepository->findAll(),
        ]);
    }

    /**
     * Enregistrer un nouvel article.
     * @Route("/backoffice/module/add", name="backoffice_module_save", methods="post")
     */
    public function save(EntityManagerInterface $em, Request $request, TeacherRepository $teacherRepository)
    {
        $module = new Module();
                // renseigner les informations
                $module->setName($request->request->get('name'))
                ->setCampain($request->request->get('campain'))
                ->setYear($request->request->get('year'));
        
                // on récupère les modules selectionnés
                $allNewTeachers = $teacherRepository->findBy(['id' => $request->request->get('teacher')]);
        
                // on ajoute les modules 1 par 1
                foreach($allNewTeachers as $newTeacher) {
                    $module->addTeacher($newTeacher);
                }

        // persister l'entité
        $em->persist($module);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_module_index');
    }

    /**
     * @Route("/backoffice/module/edit/{id}", name="backoffice_module_edit")
     */
    public function edit( $id, TeacherRepository $teacherRepository, ModuleRepository $moduleRepository): Response
    {
        return $this->render('backoffice_module/edit.html.twig', [
            'teachers' => $teacherRepository->findAll(),
            'module' => $moduleRepository->find($id),
        ]);
    }

    /**
     * @Route("/backoffice/module/update/{id}", name="backoffice_module_update")
     */
    public function update(EntityManagerInterface $em, Request $request, ModuleRepository $moduleRepository, TeacherRepository $teacherRepository, $id): Response
    {
        $module = new Module();

        $module = $moduleRepository->find($id);
        // renseigner les informations
        $module->setName($request->request->get('name'))
        ->setCampain($request->request->get('campain'))
        ->setYear($request->request->get('year'));

        // on récupère les modules selectionnés
        $allNewTeachers = $teacherRepository->findBy(['id' => $request->request->get('teacher')]);

        // on ajoute les modules 1 par 1
        foreach($allNewTeachers as $newTeacher) {
            $module->addTeacher($newTeacher);
        }


        // persister l'entité
        $em->persist($module);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_module_index');
    }

     /**
     * @Route("/backoffice/module/delete/{id}", name="backoffice_module_delete")
     */
    public function delete(ModuleRepository $moduleRepository, EntityManagerInterface $em, $id): Response
    {
        if($id==null ||$moduleRepository->find($id) == null) {
            return $this->redirectToRoute('backoffice_module_index');
        }
        
        else {
            $deleteItem = $moduleRepository->find($id);
            
            $em->remove($deleteItem);
            $em->flush();
            return $this->redirectToRoute('backoffice_module_index');
        }
    }
}