<?php

namespace App\Entity\Ecosystem;

use App\Application\Modules\Session;
use Doctrine\ORM\EntityManagerInterface;

/**
 * Class User
 * @package App\Application\Modules
 */
class User
{
    /**
     * @param EntityManagerInterface $em
     * @param null $login
     * @param null $password
     * @return int
     */
    public function login(EntityManagerInterface $em, $login = null, $password = null) : int
    {
        if (isset($login, $password)) {
            $user = $em->getRepository(\App\Entity\Doctrine\User::class)
                ->findOneBy(['login' => $login, 'password' => $password]);
            if ($user) {
                $token = md5($login . EntityId::getRandInt(0, 50000));
                $user->setToken($token);
                $em->flush();
                return $user->getId();
            }
        }
        return 0;
    }

    /**
     * @param EntityManagerInterface $em
     * @param string $token
     * @return bool|string
     */
    public function logout(EntityManagerInterface $em, string $token = null) : bool
    {
        if (isset($token)) {
            $user = $em->getRepository(\App\Entity\Doctrine\User::class)
                ->findOneBy(['token' => $token]);
            if ($user) {
                $user->setToken('');
                $em->flush();
                return true;
            }
        }
//        if (isset($_SESSION[Session::SERIALIZED_MAP_DATA])) {
//            Session::unsetSession();
//            return true;
//        }
        return false;
    }
}