<?php

namespace Pos\Helpers\Cart;

use Pos\Helpers\Cart\Storage;
use Pos\Helpers\Database;

use Exception;
use stdClass;

class Basket {

    protected $storage;
    protected $db;

    public function __construct(Storage $storage, Database $db) {
        $this->storage = $storage;
        $this->db = $db;
    }

    //product adding to the basket
    public function add(stdClass $product, $quantity) {

        if ($this->has($product)) {
            $quantity = $this->get($product)['quantity'] + $quantity;
        }
        $this->update($product, $quantity);
    }
    //updating product in the basket
    public function update(stdClass $product, $quantity) {

        $product = $this->db->get('product', 'id = ?', [$product->id])->first();

        if ($product->quantity < $quantity) {
            throw new Exception("You cannot add more than product stock");
        }

        $this->storage->add($product->id, [
            'product_id' => (int) $product->id,
            'quantity' => (int) $quantity
        ]);
    }
    //removing product in the basket
    public function remove($id) {
        $this->storage->delete($id);
    }

    //check product already in the basket
    public function has(stdClass $product) {
        return $this->storage->exists($product->id);
    }

    //get product from basket
    public function get(stdClass $product) {
        return $this->storage->get($product->id);
    }

    //clear basket
    public function clear() {
        $this->storage->clear();
    }

    //get all products in the basket
    public function all() {
        $ids = [];
        $items = [];
        foreach ($this->storage->all() as $product) {
            $ids[] = $product['product_id'];
        }
        $products = $this->db->batch('product', $ids);

        foreach ($products as $product) {
            //convert to std class because the product obj comes as readbeean php obj
            $product = $this->db->convert($product);

           $product->order_quantity = $this->get($product)['quantity'];
           $items[] = $product;
        }
        return $items;
    }

    //reducing quantity from product object
    public function reduceQuantity() {
        $ids = [];
        $items = [];
        foreach ($this->storage->all() as $product) {
            $ids[] = $product['product_id'];
        }
        $products = $this->db->batch('product', $ids);

        foreach ($products as $product) {
           $product->quantity = $product->quantity - $this->storage->get($product->id)['quantity'];
           $items[] = $product;
        }
        return $items;
    }

    //counting basket
    public function count() {
        return count($this->storage);
    }

    //get total price in basket
    public function total() {
        $total = 0;

        foreach ($this->all() as $item) {

            $product = $this->db->get('product', 'id = ?', [$item->id])->first();

            if ($product->quantity == 0) {
                continue;
            }
            $total = $total + $item->price * $item->order_quantity;
        }
        return $total;
    }

    //refresh basket
    public function refresh() {
        foreach ($this->all() as $item) {

            $product = $this->db->get('product', 'id = ?', [$item->id])->first();

            if ($product->quantity < $item->order_quantity) {
                if($product->quantity == 0) {
                    $this->remove($item->id);
                } else {
                    $this->update($product, $product->quantity);
                }
            } else if($item->order_quantity == 0) {
                $this->remove($item->id);
            }
        }
    }

    //get basket without product object
    public function getBasket() {
        return $this->storage->all();
    }
}
