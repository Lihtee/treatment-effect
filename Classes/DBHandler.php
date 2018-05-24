<?php
            ini_set("display_errors",1);
            error_reporting(E_ALL);
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DBHandler
 *
 * @author Дрей
 */
class DBHandler {
    private $dbServername = "localhost";
    private $dbUsername = "root";
    private $dbPassword = "root";
    private $dbName = "maindb";
    
 
    
    function __construct() {
     
    }

    public function SaveDataSetResult($dataSet, $email){
        $conn = mysqli_connect($this->dbServername, $this->dbUsername, 
                $this->dbPassword, $this->dbName);
        
        //Выбрать из бд id компании текущего email
        $sql = "SELECT company.id FROM company INNER JOIN email ON company.id = email.idCompany WHERE email.email = ".$email." ;";
        $res = mysqli_query($conn, $sql);
        $companyId = mysqli_fetch_row($res)[0];
        
        //Добавить в базу сущность набор_данных и взять оттуда его id.
        $sql = "INSERT INTO data_set (description, id_company) VALUES ('".$dataSet->description."','".$companyId."')";
         mysqli_query($conn, $sql);
        $dataSetId = mysqli_insert_id($conn);
        $dataSet->id = $dataSetId;
        
        //Добавить в базу сущности столбец_данных.
        $sql = "";
        //spi
        
        foreach ($dataSet->dataColumns as $dataColumn){
            $sql = $sql."INSERT INTO data_column (id_data_set, id_subtype, name) VALUES ('".$dataSetId."','".$dataColumn->id_subtype."','".$dataColumn->name."');";
        }
        mysqli_query($conn, $sql);
        //Добавить в базу сущность результат_анализа и взять его id.
        $sql = "INSETR INTO analysis_result (ate, tte, id_data_set) VALUES ('".$dataSet->result->ATE."', '".$dataSet->result->TTE."','".$dataSet->id."');";
        mysqli_query($conn, $sql);
        $analysisResultId = mysqli_insert_id($conn);
        //Добавить в базу сущности описание_переменной.
        $sql = "";
        foreach ($dataSet->result->variableDescriptions as $variableDescription){
            $sql = $sql."INSERT INTO variable_description (id_result, id_variable, id_operator, value) "
                    . "VALUES ('".$variableDescription->analysisResultId."','".$variable_description->variable->id."','".$variableDescription->operator.id."','".$variableDescription->value."');";
        }
        mysqli_query($conn, $sql);
        
        //Все сохранено в БД
        //Выбор id последнего добавленного объекта.
        $lastId = mysqli_insert_id($conn);
       
        return 1;
    }
    public function GetCatalogs(){
        $conn = mysqli_connect($this->dbServername, $this->dbUsername,
                $this->dbPassword, $this->dbName);
        $sqlSelectTypes = "SELECT type.id, type.name, subtype.id, subtype.name "
                        . "from type INNER join subtype on type.id = subtype.id_type";
      
        $res = mysqli_query($conn, $sqlSelectTypes);
        $nrows = mysqli_num_rows($res);
        $resArr = array();
        require_once '..\Classes\DataModel\Type.php';
        require_once '..\Classes\DataModel\Subtype.php';
        
        $Type = new Type();
        $Type->id = -1;
        for ($i = 0; $i<$nrows; $i++){
            $row = mysqli_fetch_row($res);
            //Если новый тип
            if ($row[0] != $Type->id){
                $Type = new Type();
                $Type->id = $row[0];
                $Type->name = $row[1];
                $resArr[] = $Type;
            }
            $Subtype = new subtype();
            $Subtype->id = $row[2];
            $Subtype->name = $row[3];
            $Type->subtypes[$Subtype->id] = $Subtype;
            $Subtype->columnType = $Type;
            
        }
        return $resArr;
    }
    public function GetDataTypes(){
        
    }
    public function Login($email){
        
    }
    function GenerateDataSetCREATE(){
        
    }
    
    function GenerateDataSetINSERT(){
        
    }
    
    public function SaveResult(){
        
    }
    function GenerateResultINSERT(){
        
    }
}
