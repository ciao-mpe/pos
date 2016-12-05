<?php

namespace Pos\Helpers\Validator;

//Valitron validation library
use Valitron\Validator as Validation;

/**
 * Validation class contains all custom validation rules
 */
class Validator{

    private $validator;
    private $db;

    public function __construct($validator, $db) {

        $this->validator = $validator;
        $this->db = $db;

        //User Validation Rules
        Validation::addRule('uniqueEmail', array($this, 'uniqueEmail'), 'is alredy taken');
        Validation::addRule('uniqueCode', array($this, 'uniqueCode'), 'is alredy exists');
        Validation::addRule('uniquePhone', array($this, 'uniquePhone'), 'is alredy exists');

        //Supplier Validation Rules
        Validation::addRule('uniqueSupplierEmail', array($this, 'uniqueSupplierEmail'), 'is alredy exists');
        Validation::addRule('uniqueSupplierTelephone', array($this, 'uniqueSupplierTelephone'), 'is alredy exists');
        Validation::addRule('isSupplier', array($this, 'isSupplier'), 'is not a valid supplier');
    }

    public function validate(array $rules, array $labels = []) {

        $this->validator->rules($rules);
        if (!empty($labels)) {
            $this->validator->labels($labels);
        }
        return $this->validator;
    }

    public function uniqueEmail($field, $value, array $params, array $fields) {

        if (!empty($params) && $params[0] === $value) {
            return true;
        }
        $user = $this->db->get('user', 'email = ?', [$value])->first();
        return ($user) ? false : true;
        
    }

    public function uniqueCode($field, $value, array $params, array $fields) {

        if (!empty($params) && $params[0] === $value) {
            return true;
        }
        $code = $this->db->get('product', 'code = ?', [$value])->first();
        return ($code) ? false : true; 
    }

    public function uniquePhone($field, $value, array $params, array $fields) {

        if (!empty($params) && $params[0] === $value) {
            return true;
        }
        $phone = $this->db->get('customer', 'phone = ?', [$value])->first();
        return ($phone) ? false : true; 
    }

    public function uniqueSupplierEmail($field, $value, array $params, array $fields) {
        if (!empty($params) && $params[0] === $value) {
            return true;
        }
        $supplier = $this->db->get('supplier', 'email = ?', [$value])->first();
        return ($supplier) ? false : true;
    }

    public function uniqueSupplierTelephone($field, $value, array $params, array $fields) {
        if (!empty($params) && $params[0] === $value) {
            return true;
        }
        $supplier = $this->db->get('supplier', 'telephone = ?', [$value])->first();
        return ($supplier) ? false : true;
    }

    public function isSupplier($field, $value, array $params, array $fields) {
        $supplier = $this->db->get('supplier', 'id = ?', [$value])->first();
        return ($supplier) ? true : false;
    }
    
}