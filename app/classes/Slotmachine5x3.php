<?php

namespace App;

class Slotmachine5x3 extends Slotmachine {

    public function __construct($images) {
        $this->name = 'Slot3x3';
        $this->width = 5;
        $this->height = 3;
        $this->images = $images;
    }

}
