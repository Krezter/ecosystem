<?php

namespace App\Controller;

use App\Entity\Ecosystem\User;
use App\Form\AuthorizationType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class LoginController extends AbstractWithSessionController
{
//    private $user;
//
//    public function __construct()
//    {
//        $this->user = new User();
//    }
//
//    /**
//     * @Route("/login", name="login");
//     *
//     * @param EntityManagerInterface $em
//     * @param Request $request
//     * @return Response
//     */
//    public function login(EntityManagerInterface $em, Request $request) : Response
//    {
//        $form = $this->createForm(AuthorizationType::class);
//        $form->handleRequest($request);
//
//        if ($form->isSubmitted() && $form->isValid()) {
//            $data = $form->getData();
//            $userId = $this->user->login($em, $data['login'], $data['password']);
//            if ($userId !== 0) {
//                return $this->redirectToRoute('load_game', ['userId' => $userId]);
//            }
//        }
//
//        return $this->authForm('Неудачная авторизация');
//    }
//
//    /**
//     * @Route("/logout");
//     *
//     * @param EntityManagerInterface $em
//     * @param Request $request
//     * @return Response
//     */
//    public function logout(EntityManagerInterface $em, Request $request) : Response
//    {
//        $token = $request->request->get('token');
//        $result = $this->user->logout($em, $token);
//        $result = $result ? 'Выход из аккаунта' : 'Ошибка! Выйти не удалось!';
//
//        return $this->authForm($result);
//    }
//
//    private function authForm($alert) : Response
//    {
//        $form = $this->createForm(AuthorizationType::class);
//
//        return $this->render('login.html.twig', [
//            'title' => 'Ecosystem',
//            'form'  => $form->createView(),
//            'alert' => $alert,
//        ]);
//    }

//    /**
//     * @Route("/registration/{login}/{password}", name="registration");
//     *
//     * @param $login
//     * @param $password
//     * @param EntityManagerInterface $em
//     * @return Response
//     */
//    public function registration($login, $password, EntityManagerInterface $em) : Response
//    {
//        $user = $em->getRepository(\App\Entity\Doctrine\User::class)->findOneBy(['login' => $login]);
//
//        if ($user) {
//            return $this->render('login.html.twig', [
//                'title' => 'Ecosystem',
//                'alert' => 'Registration fail! Such user already exists'
//            ]);
//        }
//
//        $user = new \App\Entity\Doctrine\User();
//        $user->setLogin($login)->setPassword($password);
//        $em->persist($user);
//        $em->flush();
//
//        return $this->render('game.html.twig', [
//            'title' => 'Registration',
//            'alert' => ''
//        ]);
//    }
}