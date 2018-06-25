<?php include $_SERVER['DOCUMENT_ROOT'].'/Common/common.php'; ?>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Classes/DataModel/Operator.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Classes/DataModel/AnalysisResult.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Classes/DataModel/VariableDescription.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Classes/DataModel/State.php';
    
?>
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
    /**
     * 
     * @param type $file
     * @param type $dsArray
     * @return type
     */
        public function Analyse($file, $dsArray){
        //В скрипт в качестве имен столбцов передавать их id.
        $res = $this->GenerateResult($dataSet);
        return $res;
    }
    
    
    function GenerateCmd(){
        
    }
    
    function GenerateResult($dsArray){
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
        foreach ($dataSet->dataColumns as $dataColumn){
            $variableDescription ->variable = $dataColumn;
            echo "<p>Переменная на этапе анализа добавлена </p>";
            break;
        }
        $variableDescription->value = 30;
        
        $result->AddVariableDescription($variableDescription);
        $state = new State();
        $state->id = 2;
        $dataSet->state = $state;
        $dataSet->result = $result;
        
        $resArray = array(
            'data_set' =>array(),
            'result' =>array(),
            'subgroup_best' =>array(),
            'subgriup_worst' =>array()
        );
        return $dataSet;
    }
}
