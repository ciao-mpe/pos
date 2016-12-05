<?php

namespace Pos\Helpers\Validator\Forms;

class PoForm{
    
   public static function rules() {
        return [
            'required' => [ 
                ['supplier'],
                ['date']
            ],
            'date' => [
                ['date']
            ],
            'isSupplier' => [
                ['supplier']
            ]
        ];
   }

   public static function lables() {
        return [];
   }
}
