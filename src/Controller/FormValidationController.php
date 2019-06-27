<?php

namespace App\Controller;

use App\Form\InitialParametersType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Form\SubmitButton;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class FormValidationController extends GameController
{
    /**
     * @Route("/load", name="load_game")
     *
     * @param Request $request
     * @return Response
     */
    public function loadGame(Request $request) : Response
    {
        if ($request->hasSession() && $request->getSession()->get(Security::LAST_USERNAME)) {
            return $this->redirectToRoute('continue');
        }

        return $this->redirectToRoute('login');
    }

    /**
     * @IsGranted("ROLE_USER")
     * @Route("/", name="main")
     *
     * @param Request $request
     * @return Response
     */
    public function initialValueHandler(Request $request): Response
    {
        $form = $this->createForm(InitialParametersType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $size = $data['size'];
            $time = $data['time'];
            $startBtn = $form->get('start');

            $this->clearFiles();
            if ($startBtn instanceof SubmitButton && $startBtn->isClicked()) {
                $this->startSimulation($size, $time);
            } else {
                $this->continueSimulation($size, $time);
            }

            $em = $this->getDoctrine()->getManager();
            $user = $this->getUser();
            $this->recordLogs($em, $user);
            $this->recordMap($em, $user);
        }

        return $this->getStruct($form);
    }
    
    /**
     * @Route("/saveToDatabase")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @return Response
     */
    public function saveToDatabase(Request $request) : Response
    {
//        if ($request->hasSession()) {
//            //$session = $this->getSession($request);
//            //$serializedMap = $session->get(MapFactory::SERIALIZED_MAP_DATA);
//            //MapFactory::recordMap(MapFactory::FROM_DB, $serializedMap);
//            //$session->clear();
//        }

        return $this->redirectToRoute($request->request->get('method'), [
            'size' => $request->request->get('size'),
            'time' => $request->request->get('time')
        ]);
    }

    /**
     * @Route("/saveToSession")
     * @IsGranted("ROLE_USER")
     *
     * @param Request $request
     * @return Response
     */
    public function saveToSession(Request $request) : Response
    {
        //$session = $this->getSession($request);

        return $this->redirectToRoute($request->request->get('method'), [
            'size' => $request->request->get('size'),
            'time' => $request->request->get('time')
        ]);
    }
}
