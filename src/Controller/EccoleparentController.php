<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\EditparentType;
use App\Form\ParentpasswordType;
use App\Form\ParentType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class EccoleparentController extends AbstractController
{
    /**
     * @Route("/ecole/parent", name="app_ecoleparent")
     */
    public function index(UserRepository $userRepo): Response
    {
        $users = $userRepo->findAll();
        return $this->render('eccoleparent/index.html.twig', [
            'user' => $users,
        ]);
    }

    /**
     * @Route("/ecole/parent/add", name="app_ecoleparent_add")
     */
    public function add(Request $request, UserRepository $userRepo, UserPasswordHasherInterface $hasher): Response
    {
        $user = new User();
        $user->setRoles(["ROLE_PARENT"]);
        $form = $this->createForm(ParentType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $mdp = $request->get('parent')["mdp"]["first"];
            $mdphasher = $hasher->hashPassword($user, $mdp);
            $user->setPassword($mdphasher);

            $userRepo->add($user, true);
            $this->addFlash("sucess", "Parent ajoutée");

            return $this->redirectToRoute("app_ecoleparent");
        }
        return $this->render('eccoleparent/add.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }
    /**
     * @Route("/ecole/parent/{id}/editer", name="app_ecoleparent_edit")
     */
    public function editer(User $user, Request $request, UserRepository $userRepo): Response
    {
        $form = $this->createForm(EditparentType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $userRepo->add($user, true);
            $this->addFlash("success", "Parent modifiée");
            return $this->redirectToRoute("app_ecoleparent");
        }
        return $this->render('eccoleparent/edit.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }

    /**
     * @Route("/ecole/parent/{id}/delete", name="app_ecoleparent_delete")
     */
    public function delete(User $user, UserRepository $userRepo): Response
    {
        $userRepo->remove($user, true);
        $this->addFlash("success", "Parent supprimée");
        return $this->redirectToRoute("app_ecoleparent");
    }

    /**
     * @Route("/ecole/parent/{id}/password", name="app_ecoleparentpassword_edit")
     */
    public function editerPassword(User $user, Request $request, UserRepository $userRepo, UserPasswordHasherInterface $hasher): Response
    {
        $form = $this->createForm(ParentpasswordType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {


            $mdp = $request->get('parentpassword')["mdp"]["first"];

            $mdphasher = $hasher->hashPassword($user, $mdp);
            $user->setPassword($mdphasher);
            $userRepo->add($user, true);
            $this->addFlash("success", "Parent password modifiée");
            return $this->redirectToRoute("app_ecoleparent");
        }
        return $this->render('eccoleparent/edit.html.twig', [
            "formulaire" => $form->createView()
        ]);
    }
}
