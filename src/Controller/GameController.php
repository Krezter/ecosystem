<?php

namespace App\Controller;

use App\Application\Main;
use App\Form\InitialParametersType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class GameController extends AbstractWithSessionController
{
    private $game;

    public function __construct()
    {
        $this->game = new Main();
    }

    /**
     * @Route("/start", name="start")
     *
     * @param $size
     * @param $time
     * @param EntityManagerInterface $em
     * @return Response
     */
    public function startSimulation($size, $time, EntityManagerInterface $em) : Response
    {
        file_put_contents(__DIR__.'\..\..\var\log\log.txt', '');
        $this->game->createNewMap($size);
        $this->game->continue($size, $time);
//        Сохраниение игры
//        if (isset($_POST['token'])) {
//            $this->game->recordGame($em, $_POST['token']);
//        }

        return $this->getStruct();
    }

    /**
     * @Route("/continue", name="continue")
     *
     * @param $size
     * @param $time
     * @param EntityManagerInterface $em
     * @param Request $request
     * @return Response
     */
    public function continueSimulation(EntityManagerInterface $em, Request $request, int $size = 0, int $time = 0) : Response
    {
//        Загрузка игры
//        $userId = 0;
//        if (isset($_POST['token'])) {
//            $user = $em->getRepository(User::class)
//                ->findOneBy(['token' => $_POST['token']]);
//            if ($user) {
//                $userId = $user->getId();
//            }
//        }
//        $this->game->loadGame($em, $userId);

        $this->game->continue($size, $time);
//        Сохраниение игры
//        $this->game->recordGame($em, $_POST['token']);
        return $this->getStruct();
    }

    /**
     * @return Response
     */
    private function getStruct() : Response
    {
        $form = $this->createForm(InitialParametersType::class);

        return $this->render('test.html.twig', [
            'title'    => 'Ecosystem',
            'form'     => $form->createView(),
            'textarea' => file_get_contents(__DIR__.'\..\..\var\log\log.txt'),
        ]);
    }
}