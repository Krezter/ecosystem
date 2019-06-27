<?php

namespace App\Entity\Ecosystem;



/**
 * Class LargePredator
 * Класс крупного хищника
 * @package App\Application\Struct\Entity
 */
class LargePredator extends Animal
{
    /**
     * Animal constructor.
     * @param string $name Имя крупного хищника
     * @param int $power Сила крупного хищника
     */
    public function __construct(string $name, int $power = -1)
    {
        if ($power < 0) {
            $power = EntityId::getRandInt(200, 300);
        }
        parent::__construct($name, $power);
    }

    /**
     * Изменение силы крупного хищника за счет съедания других животных
     * @param int $power Измененяемая сила
     */
    public function setPower(int $power): void
    {
        $newPower = $this->power + $power;
        if ($newPower < 200) {
            $this->power = 200;
        } elseif ($newPower < 300) {
            $this->power = $newPower;
        } else {
            $this->power = 300;
        }
    }
}