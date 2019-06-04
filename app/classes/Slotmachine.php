<?php

namespace App;

class Slotmachine extends Abstracts\Slotmachine {

    const FAIRNESS_CONF = 0.5;

    public function __construct(string $name, int $width, int $height, array $images) {
        $this->name = $name;
        $this->width = $width;
        $this->height = $height;
        $this->images = $images;
        $this->result;
    }

    public function spin(): array {
        $result = [];
        $row = [];

        for ($i = 0; $i < $this->height; $i++) {
            for ($x = 0; $x < $this->width; $x++) {
                shuffle($this->images);
                $row [$x] = $this->images[0];
            }
            $result [] = $row;
        }

        return $this->result = $result;
    }

    public function getMiddleRow() {
        $array = $this->result;
        $array_size = count($array) - 1;
        $middle_row = $array[ceil($array_size / 2)];

        return $middle_row;
    }

    public function checkWin() {
        $middle_row = $this->getMiddleRow();
        $row_value = $middle_row[0];
        $result = false;

        foreach ($middle_row as $value) {
            if ($row_value == $value) {
                $result = true;
            } else {
                return false;
            }
        }

        return $result;
    }

    public function getResult() {
        return $this->result;
    }

}
