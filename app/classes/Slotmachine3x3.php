<?php

namespace App;

class Slotmachine3x3 extends Slotmachine {

    public function __construct($images) {
        $this->name = 'Slot3x3';
        $this->width = 3;
        $this->height = 3;
        $this->images = $images;
    }

}
