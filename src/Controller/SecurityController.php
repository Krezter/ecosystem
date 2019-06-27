<?php

namespace App\Controller;

use App\Entity\Doctrine\GameLogs;
use App\Entity\Doctrine\MapSerialization;
use App\Entity\Doctrine\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     *
     * @param AuthenticationUtils $authenticationUtils
     * @return Response
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response
    {
        $error = $authenticationUtils->getLastAuthenticationError();
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     * @IsGranted("ROLE_USER")
     */
    public function logout(): void
    {
    }

    /**
     * @Route("/register", name="register")
     *
     * @param UserPasswordEncoderInterface $pe
     * @param Request $request
     * @param CsrfTokenManagerInterface $csrfTM
     * @return Response
     */
    public function register(UserPasswordEncoderInterface $pe, Request $request, CsrfTokenManagerInterface $csrfTM) : Response
    {
        if ($request->isMethod('POST')) {
            $token = new CsrfToken('registration', $request->request->get('_csrf_token'));
            if (!$csrfTM->isTokenValid($token)) {
                return $this->render('security/register.html.twig', [
                    'error' => 'Ошибка формы',
                ]);
            }

            $em = $this->getDoctrine()->getManager();
            if ($em->getRepository(User::class)->findOneBy(['username' => $request->request->get('username')])) {
                return $this->render('security/register.html.twig', [
                    'error' => 'Такой пользователь уже существует',
                ]);
            }

            $user = new User();
            $user->setUsername($request->request->get('username'));
            $user->setPassword($pe->encodePassword(
                $user,
                $request->request->get('password')
            ));
            $em->persist($user);
            $em->flush();

            $logs = new GameLogs();
            $logs->setUserId($user->getId());
            $em->persist($logs);

            $mapS = new MapSerialization();
            $mapS->setUserId($user->getId());
            $em->persist($mapS);
            $em->flush();

            return $this->redirectToRoute('login');
        }

        return $this->render('security/register.html.twig', [
            'error' => null,
        ]);
    }
}