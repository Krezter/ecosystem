<?php

namespace App\Entity\Ecosystem;



/**
 * Class Herbivorous
 * Класс травоядного
 * @package App\Application\Struct\Entity
 */
class Herbivorous extends Animal
{
    /**
     * Animal constructor.
     * @param string $name Имя травоядного
     * @param int $power Сила травоядного
     */
    public function __construct(string $name, int $power = -1)
    {
        if ($power < 0) {
            $power = EntityId::getRandInt(0, 100);
        }
        parent::__construct($name, $power);
    }

    /**
     * Увеличение силы травоядного за счет растения
     * @param int $power Питательность растения
     */
    public function setPower(int $power) : void
    {
        $newPower = $this->power + $power;
        if ($newPower < 100) {
            $this->power = $newPower;
        } else {
            $this->power = 100;
        }
    }
}