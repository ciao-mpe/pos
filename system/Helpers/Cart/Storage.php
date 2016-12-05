<?php

namespace Pos\Helpers\Cart;
use Countable;

class Storage implements Countable{

    protected $basket;

    public function __construct($basket = 'default'){
        if (!isset($_SESSION[$basket])) {
           $_SESSION[$basket] = [];
        }
        $this->basket = $basket;
    }

    public function add($index, $value) {
        $_SESSION[$this->basket][$index] = $value;
    }

    public function get($index){
        if (!$this->exists($index)) {
           return NULL;
        }
        return $_SESSION[$this->basket][$index];
    }

    public function exists($index) {
        return isset($_SESSION[$this->basket][$index]);
    }

    public function all() {
        return $_SESSION[$this->basket];
    }

    public function delete($index) {
        if ($this->exists($index)) {
            unset($_SESSION[$this->basket][$index]);
        }
    }

    public function count() {
        return count($_SESSION[$this->basket]);
    }

    public function clear() {
        unset($_SESSION[$this->basket]);
    }
}