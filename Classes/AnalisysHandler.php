<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of AnalisysHandler
 *
 * @author Дрей
 */
class AnalisysHandler {
    public function Analyse($file, $dataSet){
        //В скрипт в качестве имен столбцов передавать их id.
        $res = $this->Analyse($file, $dataSet);
        return $res;
    }
    
    function GenerateCmd(){
        
    }
    
    function GenerateResult($dataSet){
        $op1 = new Operator();
        $op1->id = 1;
        $op1->value = ">";
        
        $op2 = new Operator();
        $op2->id = 2;
        $op2->value = "<";
        
        $result = new Analysis_result();
        $result->ATE = 4;
        $result ->TTE = 10;
        
        $variableDescription = new Variable_description();
        $variableDescription ->operator = $op1;
        $variableDescription ->variable = $dataSet->dataColumns[0];
        $variableDescription->value = 30;
        
        $result->AddVariableDescription($variableDescription);
        
        return $dataSet;
    }
}
