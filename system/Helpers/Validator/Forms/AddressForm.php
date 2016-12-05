<?php

namespace Pos\Helpers\Validator\Forms;

class AddressForm{
    
   public static function rules() {
        return [
            'required' => [ 
                ['address1'],
                ['city'],
                ['postal_code'],
                ['telephone']
            ],
            'optional' => [
                ['address2'],
            ],
            'length' => [
                ['telephone', 10]
            ]
        ];
   }

   public static function lables() {
        return [
            'address1' => "Address Line 1",
            'address2' => "Address Line 2",
            'postal_code' => "Postal Code"
        ];
   }
}
