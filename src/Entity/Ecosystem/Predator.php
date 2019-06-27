<?php

namespace App\Entity\Ecosystem;



/**
 * Class Predator
 * Класс сущности хищника
 * @package App\Application\Struct\Entity
 */
class Predator extends Animal
{
    /**
     * Animal constructor.
     * @param string $name Имя хищника
     * @param int $power Сила хищника
     */
    public function __construct(string $name, int $power = -1)
    {
        if ($power < 0) {
            $power = EntityId::getRandInt(100, 200);
        }
        parent::__construct($name, $power);
    }

    /**
     * Изменение силы хищника за счет съедания других животных
     * @param int $power Измененяемая сила
     */
    public function setPower(int $power): void
    {
        $newPower = $this->power + $power;
        if ($newPower < 100) {
            $this->power = 100;
        } elseif ($newPower < 200) {
            $this->power = $newPower;
        } else {
            $this->power = 200;
        }
    }
}