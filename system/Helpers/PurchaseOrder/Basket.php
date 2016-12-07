<?php

namespace Pos\Helpers\PurchaseOrder;

use Pos\Helpers\Cart\Basket as Cart;

use stdClass;

class Basket extends Cart{

    public function add(stdClass $product, $quantity) {
        if ($this->has($product)) {
            $quantity = $quantity;
        }
        $this->update($product, $quantity);
    }

    public function update(stdClass $product, $quantity) {
        $this->storage->add($product->id, [
            'product_id' => (int) $product->id,
            'quantity' => (int) $quantity
        ]);
    }

    public function total() {
        $total = 0;
        foreach ($this->all() as $item) {
            $product = $this->db->get('product', 'id = ?', [$item->id])->first();
            $total = $total + $item->price * $item->order_quantity;
        }
        return $total;
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
