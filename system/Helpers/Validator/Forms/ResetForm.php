<?php

namespace Pos\Helpers\Validator\Forms;

class ResetForm{
    
   public static function rules() {
        return [
            'required' => [ 
                ['password'],
                ['confirm_password'],
            ],
            'lengthMin' => [
                ['password', 6]
            ],
            'equals' => [
                ['confirm_password', 'password']
            ]
        ];
   }

   public static function lables() {
        return [
            'confirm_password' => "Confirm Password",
        ];
   }
}
