<?php

namespace App\Entity\Ecosystem;

/**
 * Class Observer
 * Класс наблюдателя
 * @package App\Application\Struct\Entity
 */
class Observer extends Movement implements BaseEntity
{
    private $id;

    /**
     * Observer constructor.
     * @param int $id Идентификатор наблюдателя
     */
    public function __construct(int $id)
    {
        $this->id     = $id;
    }

    /**
     * Информация о наблюдателе
     * @return array Массив с данными о наблюдателе
     */
    public function getInfo() : array
    {
        return [
            'id' => $this->id
        ];
    }
}