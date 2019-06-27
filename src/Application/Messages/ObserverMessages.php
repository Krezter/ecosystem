<?php

namespace App\Application\Messages;

use App\Application\Logging\LoggerInterface;
use App\Entity\Ecosystem\Animal;
use App\Entity\Ecosystem\BaseEntity;
use App\Entity\Ecosystem\Observer;
use App\Entity\Ecosystem\Plant;

/**
 * Class ObserverMessages
 * Сообщения наблюдателя
 * @package App\Application\Messages
 */
class ObserverMessages
{

    private $logger;

    /**
     * ObserverMessages constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Информация о наблюдателе
     * @param array $observer Данные наблюдателя
     * @param string $date Дата и время наблюдений
     */
    public function observerInfo(array $observer, string $date) : void
    {
        $observerInfo = 'Новая запись наблюдателя c id '.$observer['id'];
        $dateInfo = 'Дата: '.$date;
        $this->logger->print($observerInfo);
        $this->logger->print($dateInfo);
    }

    /**
     * Информация о наблюдаемой сущности
     * @param BaseEntity $entity Наблюдаемой объект сущности
     */
    public function observationInfo(BaseEntity $entity) : void
    {
        if (isset($entity)) {
            if ($entity instanceof Animal) {
                $entityInfo = 'Животное';
            } else {
                $entityInfo = 'Растение';
            }
            $entityInfo .= self::getEntityInfo($entity);
            $this->logger->print($entityInfo);
        }
    }

    /**
     * Информация об уничтожении растения
     */
    public function removePlant() : void
    {
        $outInfo = 'Наблюдатель забрал растение с собой';
        $this->logger->print($outInfo);
    }

    /**
     * Вызов информации о сущности
     * @param BaseEntity $entity Объект выводимой сущности
     * @return string
     */
    public static function getEntityInfo(BaseEntity $entity) : string
    {
        $entityInfo = $entity->getInfo();

        if ($entity instanceof Observer) {
            return ' наблюдателя с id '.$entityInfo['id'];
        }
        if ($entity instanceof Animal) {
            return ' '.$entityInfo['name'].' с силой '.$entityInfo['power'];
        }
        if ($entity instanceof Plant) {
            return ' '.$entityInfo['name'].' с питательностью '.$entityInfo['nutritious'];
        }

        return 'Ошибка при вызове информации о сущности';
    }
}