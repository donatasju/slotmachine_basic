<?php

namespace App\Abstracts;

abstract class Slotmachine {

    protected $name;
    protected $width;
    protected $height;
    protected $images;
    protected $result;

    /** constructs slotmachine, gives it a name and size. For example 3x3 or 5x3 */
    abstract public function __construct(string $name, int $width, int $height, array $images);

    /** Spins slotmachine and returns array */
    abstract public function spin(): array;
}
