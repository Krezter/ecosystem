<?php

namespace App\Controller;

use App\Application\Main;
use App\Entity\Doctrine\GameLogs;
use App\Entity\Doctrine\MapSerialization;
use App\Entity\Doctrine\User;
use Doctrine\Common\Persistence\ObjectManager;;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class GameController
 * @package App\Controller
 * @IsGranted("ROLE_USER")
 */
class GameController extends AbstractController
{
    private $game;

    public function __construct()
    {
        $this->game = new Main();
    }

    /**
     * @param int $size
     * @param int $time
     * @return void
     */
    protected function startSimulation(int $size, int $time) : void
    {
        $this->game->createNewMap($size);
        $this->game->continue($size, $time);
    }

    /**
     * @param int $size
     * @param int $time
     * @return void
     */
    protected function continueSimulation(int $size, int $time) : void
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();

        $this->loadMap($em, $user);
        $this->loadLogs($em, $user);
        $this->game->continue($size, $time);
    }

    /**
     * @param FormInterface $form
     * @return Response
     */
    protected function getStruct(FormInterface $form) : Response
    {
        $textarea = file_get_contents(__DIR__.'\..\..\var\log\log.txt');
        $this->clearFiles();

        return $this->render('game.html.twig', [
            'title'    => 'Ecosystem',
            'form'     => $form->createView(),
            'textarea' => $textarea,
        ]);
    }

    /**
     * @param ObjectManager $em
     * @param User $user
     * @return void
     */
    protected function loadLogs(ObjectManager $em, User $user) : void
    {
        $logs = $em->getRepository(GameLogs::class)->findOneBy(['user_id' => $user->getId()]);

        if ($logs) {
            file_put_contents(__DIR__.'\..\..\var\log\log.txt', $logs->getLog());
        }
    }

    /**
     * @param ObjectManager $em
     * @param User $user
     * @return void
     */
    protected function recordLogs(ObjectManager $em, User $user) : void
    {
        $text = file_get_contents(__DIR__.'\..\..\var\log\log.txt');
        $logs = $em->getRepository(GameLogs::class)->findOneBy(['user_id' => $user->getId()]);

        if ($logs) {
            $logs->setLog($text);
            $em->persist($logs);
            $em->flush();
        }
    }

    /**
     * @param ObjectManager $em
     * @param User $user
     */
    private function loadMap(ObjectManager $em, User $user) : void
    {
        $mapSer = $em->getRepository(MapSerialization::class)->findOneBy(['user_id' => $user->getId()]);

        if ($mapSer) {
            file_put_contents(__DIR__.'\..\..\var\dump.txt', $mapSer->getMap());
            $this->game->loadGame();
        }
    }

    /**
     * @param ObjectManager $em
     * @param User $user
     */
    protected function recordMap(ObjectManager $em, User $user) : void
    {
        $mapSer = $em->getRepository(MapSerialization::class)->findOneBy(['user_id' => $user->getId()]);

        if ($mapSer) {
            $mapSer->setMap(file_get_contents(__DIR__.'\..\..\var\dump.txt'));
            $em->persist($mapSer);
            $em->flush();
        }
    }

    protected function clearFiles() : void
    {
        file_put_contents(__DIR__.'\..\..\var\dump.txt', '');
        file_put_contents(__DIR__.'\..\..\var\log\log.txt', '');
    }
}