<?php

namespace Pos\Helpers\Validator\Forms;

class SupplierForm{
    
   public static function rules($email = null, $telephone = null) {
        return [
            'required' => [ 
                ['company_name'],
                ['email'],
                ['address'],
                ['telephone'],
            ],
            'email' => [
                ['email']
            ],
            'uniqueSupplierEmail' => [
                ['email', $email]
            ],
            'uniqueSupplierTelephone' => [
                ['telephone', $telephone]
            ],
            'length' => [
                ['telephone', 10]
            ]
        ];
   }

   public static function lables() {
        return [
            'company_name' => "Company Name"
        ];
   }
}
