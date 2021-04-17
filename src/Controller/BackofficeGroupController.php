<?php

namespace App\Controller;

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

class BackofficeGroupController extends AbstractController
{
    /**
     * @Route("/backoffice/groupes", name="backoffice_group_index")
     */
    public function index(GroupRepository $groupRepository): Response
    {
        return $this->render('backoffice_group/index.html.twig', [
            'groups' => $groupRepository->findAll(),
        ]);
    }

    /**
     * @Route("/backoffice/groupe/add", name="backoffice_group_add", methods="get")
     */
    public function add(): Response
    {
        return $this->render('backoffice_group/add.html.twig');
    }

    /**
     * Enregistrer un nouvel article.
     * @Route("/backoffice/groupe/add", name="backoffice_group_save", methods="post")
     */
    public function save(EntityManagerInterface $em, Request $request, TeacherRepository $teacherRepository)
    {
        $group = new Group();
                // renseigner les informations
                $group->setName($request->request->get('name'))
                ->setCampain($request->request->get('campain'))
                ->setSemester($request->request->get('semester'))
                ->setType($request->request->get('type'));

        // persister l'entité
        $em->persist($group);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_group_index');
    }

    /**
     * @Route("/backoffice/groupe/edit/{id}", name="backoffice_group_edit")
     */
    public function edit( $id, GroupRepository $groupRepository): Response
    {
        return $this->render('backoffice_group/edit.html.twig', [
            'group' => $groupRepository->find($id),
        ]);
    }

    /**
     * @Route("/backoffice/groupe/update/{id}", name="backoffice_group_update")
     */
    public function update(EntityManagerInterface $em, Request $request, GroupRepository $groupRepository, $id): Response
    {
        $group = new Group();
        $group = $groupRepository->find($id);
                // renseigner les informations
                $group->setName($request->request->get('name'))
                ->setCampain($request->request->get('campain'))
                ->setSemester($request->request->get('semester'))
                ->setType($request->request->get('type'));

        // persister l'entité
        $em->persist($group);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_group_index');
    }

     /**
     * @Route("/backoffice/groupe/delete/{id}", name="backoffice_group_delete")
     */
    public function delete(GroupRepository $groupRepository, EntityManagerInterface $em, $id): Response
    {
        if($id==null ||$groupRepository->find($id) == null) {
            return $this->redirectToRoute('backoffice_group_index');
        }
        
        else {
            $deleteItem = $groupRepository->find($id);
            
            $em->remove($deleteItem);
            $em->flush();
            return $this->redirectToRoute('backoffice_group_index');
        }
    }
}