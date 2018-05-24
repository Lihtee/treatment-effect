<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Analysis_result
 *
 * @author Дрей
 */
class Analysis_result {
    public $id;
    public $ATE;
    public $TTE;
    //External 
    public $variableDescriptions;
    public $dataset;
    
    public function AddVariableDescription($variableDescription){
        $this->variableDescriptions[] = $variableDescription;
        $variableDescription->result =$this;
    }
}
