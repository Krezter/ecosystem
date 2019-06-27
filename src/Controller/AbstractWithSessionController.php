<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class AbstractWithSessionController extends AbstractController
{
    protected function getSession(Request $request) : SessionInterface
    {
        if ($request->hasSession()) {
            return $request->getSession();
        }

        $session = new Session();
        $session->start();
        return $session;
    }
}
