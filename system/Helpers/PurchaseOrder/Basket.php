<?php

namespace Pos\Helpers\PurchaseOrder;

use Pos\Helpers\Cart\Storage;
use Pos\Helpers\Database;

class Basket {

    private $storage;
    private $db;

    public function __construct(Storage $storage, Database $db) {
        $this->storage = $storage;
        $this->db = $db;
    }

    public function add($pid, $quantity) {
        if ($this->has($pid)) {
            $quantity = $quantity;
        }
        $this->update($pid, $quantity);
    }

    public function update($pid, $quantity) {
        $this->storage->add($pid, [
            'id' => (int) $pid,
            'quantity' => (int) $quantity
        ]);
    }

    public function all() {
        $ids = [];
        $items = [];
        foreach ($this->storage->all() as $product) {
            $ids[] = $product['id'];
        }
        $products = $this->db->batch('product', $ids);

        foreach ($products as $product) {
            //convert to std class because the product obj comes as readbeean php obj
            $product = $this->db->convert($product);

           $product->order_quantity = $this->get($product->id)['quantity'];
           $items[] = $product;
        }
        return $items;
    }

    public function get($pid) {
        return $this->storage->get($pid);
    }

    public function has($pid) {
        return $this->storage->exists($pid);
    }

    public function remove($pid) {
        $this->storage->delete($pid);
    }

    public function clear() {
        $this->storage->clear();
    }
    
    public function total() {
        $total = 0;

        foreach ($this->all() as $item) {

            $product = $this->db->get('product', 'id = ?', [$item->id])->first();

            $total = $total + $item->price * $item->order_quantity;
        }
        return $total;
    }

    public function count() {
        return count($this->storage);
    }

    public function refresh() {
        foreach ($this->all() as $item) {

            $product = $this->db->get('product', 'id = ?', [$item->id])->first();
            if(!$product) {
                $this->remove($item->id);
            }
        }
    }

}