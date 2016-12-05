<?php

namespace Pos\Helpers\Validator\Forms;

class ProductForm{
    
   public static function rules($code = null) {
        return [
            'required' => [ 
                ['title'],
                ['code'],
                ['description'],
                ['price'],
                ['quantity'],
                ['reorder']
            ],
            'uniqueCode' => [
                ['code', $code]
            ],
            'length' => [
                ['code', 6]
            ],
            'lengthMin' => [
                ['title', 10],
                ['description', 20]
            ],
            'integer' => [
                ['quantity'],
                ['reorder']
            ],
            'numeric' => [
                ['price']
            ],
            'min' => [
                ['price', 1]
            ]
        ];
   }

   public static function lables() {
      return [];
   }
}
