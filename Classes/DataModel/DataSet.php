<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DataSet
 *
 * @author Дрей
 */
class DataSet {
    //Inner fields.
    public $id;
    public $name;
    public $description;
    
    //External fields.
    public $company;
    public $state;
    public $branch;
    public $dataColumns;
    public $result;
    
    public function AddDataColumn($dataColumn){
        $this->dataColumns[] = $dataColumn;
        $dataColumn->dataSet = $this;
    }
}
