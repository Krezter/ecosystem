<?php

namespace App\Entity\Ecosystem;

/**
 * Class Animal
 * Базовый класс животных
 * @package App\Application\Struct\Entity
 */
abstract class Animal extends Movement implements BaseEntity
{
    protected $name;
    protected $power;

    /**
     * Animal constructor.
     * @param string $name Имя животного
     * @param int $power Сила животного
     */
    public function __construct(string $name, int $power)
    {
        $this->name   = $name;
        $this->power  = $power;
    }

    /**
     * Информация о растении
     * @return array Массив с данными о растении
     */
    public function getInfo() : array
    {
    	return [
    	    'name' => $this->name,
            'power' => $this->power
        ];
    }

    /**
     * Изменение силы животного при взаимодействии сущностей
     * @param int $power Изменяемая сила
     */
    abstract public function setPower(int $power) : void;
}