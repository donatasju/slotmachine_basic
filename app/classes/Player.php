<?php

namespace App;

use Core\Cookie;

class Player extends Cookie {

    public function setBalance(int $balance) {
        $cookie_data = ['balance' => $balance];
        $this->save($cookie_data, 3600);
    }

    public function getBalance() {
        $cookie_data = $this->read();
        $balance = $cookie_data['balance'] ?? 0;

        return $balance;
    }

}