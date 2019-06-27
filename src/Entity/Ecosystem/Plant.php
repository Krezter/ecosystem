<?php

namespace App\Entity\Ecosystem;

/**
 * Class Plant
 * Класс сущности растения
 * @package App\Application\Struct\Entity
 */
class Plant implements BaseEntity
{
    private $name;
    private $nutritious;

    /**
     * Plant constructor.
     * @param string $name Название растения
     * @param int $nutritious Уровень питательности
     */
    public function __construct(string $name, int $nutritious)
    {
        $this->name = $name;
        $this->nutritious = $nutritious;
    }


    /**
     * Информация о растении
     * @return array Массив с данными о растении
     */
    public function getInfo(): array
    {
        return [
            'name' => $this->name,
            'nutritious' => $this->nutritious
        ];
    }
}