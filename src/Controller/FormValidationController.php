<?php

namespace App\Controller;

use App\Application\Factory\MapFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FormValidationController extends AbstractWithSessionController
{
    /**
     * @Route("/", name="load_game")
     *
     * @param Request $request
     * @param null $userId
     * @return Response
     */
    public function loadGame(Request $request, $userId = null) : Response
    {
        if (isset($userId)) {
            /**
             * TODO доделать
             */
            return $this->redirectToRoute('continue', ['size' => 0, 'time' => 0]);
        }

        if ($request->hasSession()) {
            return $this->redirectToRoute('continue', ['size' => 0, 'time' => 0]);
        }

        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/saveToDatabase")
     *
     * @param Request $request
     * @return Response
     */
    public function saveToDatabase(Request $request) : Response
    {
        if ($request->hasSession()) {
            $session = $this->getSession($request);
            //$serializedMap = $session->get(MapFactory::SERIALIZED_MAP_DATA);
            //MapFactory::recordMap(MapFactory::FROM_DB, $serializedMap);
            $session->clear();
        }

        return $this->redirectToRoute($request->request->get('method'), [
            'size' => $request->request->get('size'),
            'time' => $request->request->get('time')
        ]);
    }

    /**
     * @Route("/saveToSession")
     *
     * @param Request $request
     * @return Response
     */
    public function saveToSession(Request $request) : Response
    {
        $session = $this->getSession($request);

        return $this->redirectToRoute($request->request->get('method'), [
            'size' => $request->request->get('size'),
            'time' => $request->request->get('time')
        ]);
    }

    /**
     * @Route("/test")
     *
     * @param Request $request
     * @return Response
     */
    public function test(Request $request) : Response
    {
        $session = $this->getSession($request);

        return $this->redirectToRoute($request->request->get('method'), [
            'size' => $request->request->get('size'),
            'time' => $request->request->get('time')
        ]);
    }
}
