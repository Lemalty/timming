<?php

namespace App\Controller;

use App\Entity\Task;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class BackofficeAdminController extends AbstractController
{
    /**
     * @Route("/backoffice/admin", name="backoffice_admin_index")
     */
    public function index(EntityManagerInterface $em): Response
    {
        // dd($em->getRepository( User::class )->findAll());
        return $this->render('backoffice_admin/index.html.twig', [
            'controller_name' => 'BackofficeAdminController',
            'users' => $em->getRepository( User::class )->findAll(),
        ]);
    }

    /**
     * @Route("/backoffice/admin/add", name="backoffice_admin_add", methods="get")
     */
    public function add(EntityManagerInterface $em): Response
    {
        return $this->render('backoffice_admin/add.html.twig', [
            'controller_name' => 'BackofficeAdminController',            
        ]);
    }

    /**
     * Enregistrer un nouvel article.
     * @Route("/backoffice/admin/add", name="backoffice_admin_save", methods="post")
     */
    public function save(EntityManagerInterface $em, Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        // dd($request->request);
        $user = new User();
        $roles[] = $request->request->get('roles');
        
        // renseigner les informations
        $user->setEmail($request->request->get('email'))
         ->setRoles($roles)
         ->setPassword($passwordEncoder->encodePassword($user, $request->request->get('password')));
         
        // persister l'entité
        $em->persist($user);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_admin_index');
    }

    /**
     * @Route("/backoffice/admin/edit/{id}", name="backoffice_admin_edit")
     */
    public function edit(EntityManagerInterface $em, $id): Response
    {
        // dd($em->getRepository( Task::class )->find($id));
        return $this->render('backoffice_admin/edit.html.twig', [
            'controller_name' => 'BackofficeAdminController',
            'user' => $em->getRepository( User::class )->find($id),            
        ]);
    }

    /**
     * @Route("/backoffice/admin/update/{id}", name="backoffice_admin_update")
     */
    public function update(EntityManagerInterface $em, Request $request, $id)
    {
        // dd($request->request);
        $user = $em->getRepository( User::class )->find($id);
        $roles[] = $request->request->get('roles');
        
        // renseigner les informations
        $user->setEmail($request->request->get('email'))
         ->setRoles($roles);
         
        // persister l'entité
        $em->persist($user);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_admin_index');
    }

    /**
     * @Route("/backoffice/admin/delete/{id}", name="backoffice_admin_delete")
     */
    public function delete(User $user, EntityManagerInterface $em)
    {
        $em->remove($user);
        // déclencher le traitements SQL
        $em->flush();
        // redirection
        return $this->redirectToRoute('backoffice_admin_index');
    }
}