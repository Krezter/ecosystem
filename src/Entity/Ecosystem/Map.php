<?php


namespace App\Entity\Ecosystem;

/**
 * Class Map
 * Класс структуры карты
 * @package App\Application\Struct
 */
class Map
{
    private $map;

    /**
     * Создание скелета карты
     * @param int $size Размер карты от 0
     */
    public function addMap(int $size) : void
    {
        $this->map = [];
        for ($x = 0; $x <= $size; $x++) {
            $this->map[$x] = [];
            for ($y = 0; $y <= $size; $y++) {
                $this->map[$x][$y] = new Tile();
            }
        }
    }

    /**
     * Взятие клетки по его координатам
     * @param int $x Координата по х
     * @param int $y Координата по у
     * @return Tile Объект клетки
     */
    public function getTile(int $x, int $y) : Tile
    {
        return $this->map[$x][$y];
    }

    /**
     * @return int
     */
    public function getSize() : int
    {
        return count($this->map);
    }
}