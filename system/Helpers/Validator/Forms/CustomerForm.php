<?php

namespace Pos\Helpers\Validator\Forms;

class CustomerForm{
    
   public static function rules($email) {
        return [
            'required' => [ 
                ['first_name'],
                ['last_name'],
                ['email'],
            ],
            'email' => [
                ['email']
            ],
            'uniqueEmail' => [
                ['email', $email]
            ]
        ];
   }

   public static function lables() {
        return [
            'first_name' => "First Name",
            'last_name' => "Last Name",
        ];
   }
}
