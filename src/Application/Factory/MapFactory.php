<?php

namespace App\Application\Factory;

use App\Entity\Doctrine\MapSerialization;
use App\Entity\Doctrine\User;
use App\Entity\Ecosystem\Herbivorous;
use App\Entity\Ecosystem\LargePredator;
use App\Entity\Ecosystem\Observer;
use App\Entity\Ecosystem\Plant;
use App\Entity\Ecosystem\Predator;
use App\Entity\Ecosystem\Map;
use App\Entity\Ecosystem\Tile;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;

/**
 * Class MapFactory
 * @package App\Application\Factory
 */
class MapFactory
{
    public const FROM_FILE = 1;
    public const FROM_DB = 2;
    public const FROM_SESSION = 3;
    public const SERIALIZED_MAP_DATA = 'serialized_map_data';

    /**
     * @param int $loadFrom
     * @param EntityManagerInterface $em
     * @param int $userId
     * @return Map
     */
    public static function loadMap(int $loadFrom, EntityManagerInterface $em, int $userId) : Map
    {
        switch ($loadFrom) {
            case self::FROM_FILE:
                $map = file_get_contents(__DIR__.'/../var/dump.txt');
                break;
            case self::FROM_DB:
                if ($userId !== 0) {
                    $serMap = $em->getRepository(MapSerialization::class)
                        ->findOneBy(['user_id' => $userId]);
                    $map = $serMap ? $serMap->getMap() : null;
                }
                break;
            case self::FROM_SESSION:
                $map = null;
                /**
                 * TODO Session
                 */
                break;
        }
        if (!empty($map)) {
            return unserialize(
                $map,
                [
                    'allowed_classes' => [
                        Map::class,
                        Tile::class,
                        Predator::class,
                        LargePredator::class,
                        Herbivorous::class,
                        Observer::class,
                        Plant::class
                    ]
                ]
            );
        }
        $map = new Map();
        $map->addMap(0);
        return $map;
    }

    /**
     * @param int $saveTo
     * @param Map $map
     * @return void
     */
    public static function recordMap(int $saveTo, Map $map) : void
    {
        switch ($saveTo) {
            case self::FROM_FILE:
                file_put_contents(__DIR__.'/../var/dump.txt', serialize($map));
                break;
            case self::FROM_DB:
//                if ($token && $em) {
//                    $user = $em->getRepository(User::class)
//                        ->findOneBy(['token' => $token]);
//                    if ($user === null) {
//                        throw new RuntimeException('Ошибка при получении текущего пользователя');
//                    }
//                    $serializationMap = $em->getRepository(MapSerialization::class)
//                        ->findOneBy(['user_id' => $user->getId()]);
//                    if ($serializationMap === null) {
//                        throw new RuntimeException('Ошибка при получении карты пользователя. Карты пользователя отсутствует');
//                    }
//                    $serializationMap->setMap(serialize($map));
//                    $serializationMap->setUserId($user->getId());
//                    $em->flush();
//                }
                break;
            case self::FROM_SESSION:
                //$_SESSION[Session::SERIALIZED_MAP_DATA] = serialize($map);
                $session->set(self::SERIALIZED_MAP_DATA, serialize($map));
                /**
                 * TODO Session
                 */
                break;
        }
    }
}