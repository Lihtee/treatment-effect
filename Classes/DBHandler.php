<?php include $_SERVER['DOCUMENT_ROOT'].'/Common/common.php'; ?>
<?php
             
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
    private $conn;
     
    public function __construct() {
        $conn = mysqli_connect($this->dbServername, $this->dbUsername, 
                $this->dbPassword, $this->dbName);
    }
    /**
     * 
     * @return assocArray Ассоциативный массив следующего вида: 
     * [[['data_set.name'],['analysis_result.id'],['state_analysis.id'],['state_analysis.name'] ], 
     * [...], 
     * [...]]
     */
    public function getShortAnalysisResults($userEmail)
    {
        $sql = "SELECT data_set.name , analysis_result.id, state_analysis.id, state_analysis.name 
                fROM (((analysis_result INNER JOIN data_set ON analysis_result.id_data_set = data_set.id) 
                	INNER JOIN state_analysis ON data_set.id_state_analysis = state_analysis.id) 
                    inner join company on company.id = data_set.id_company) 
                    INNER join email on email.id_company = company.id
                where email.email = '".$userEmail."'";
        $SQLres = mysqli_query($conn, $sql);
        $res = array();
        $nrows = mysqli_num_rows($SQLres);
        for ($i = 0; $i < $nrows; $i++){
            $row = mysqli_fetch_row($result);
            $res[$i]['data_set.name'] = $row[0];
            $res[$i]['analysis_result.id'] = $row[1];
            $res[$i]['state_analysis.id'] = $row[2];
            $res[$i]['state_analysis.name'] = $row[3];
        }
        
        return $res;
    }
 
    
    

    public function SaveDataSetResult($dataSet, $email){
        $conn = mysqli_connect($this->dbServername, $this->dbUsername, 
                $this->dbPassword, $this->dbName);
        
        //Выбрать из бд id компании текущего email
        $sql = "SELECT company.id FROM company INNER JOIN email ON company.id = email.id_company WHERE email.email = '".$email."' ;";
        $res = mysqli_query($conn, $sql);
        $companyId = mysqli_fetch_row($res)[0];
        echo "<p> Email: ". $email."</p>";
        echo "<p> Айди компании: ".$companyId."</p>";
        //Добавить в базу сущность набор_данных и взять оттуда его id.
        $sql = "INSERT INTO data_set (name, description, id_company, id_state_analysis) VALUES ('".$dataSet->description."','".$dataSet->description."','".$companyId."', '".$dataSet->state->id."')";
         mysqli_query($conn, $sql);
        $dataSetId = mysqli_insert_id($conn);
        $dataSet->id = $dataSetId;
        echo "<p> Айди набора данных: ".$dataSet->id."</p>";
        //Добавить в базу сущности столбец_данных.
        $res = 1;
        
        foreach ($dataSet->dataColumns as $dataColumn){
            $sql = "INSERT INTO data_column (id_data_set, id_subtype, name) VALUES ('".$dataSetId."','".$dataColumn->subtype->id."','".$dataColumn->name."');";
            $res = $res & mysqli_query($conn, $sql);
            $dataColumnId = mysqli_insert_id($conn);
            $dataColumn->id = $dataColumnId;
        }
        
        echo "<p> Добавлены ли столбцы: ".$res."</p>";
        //Добавить в базу сущность результат_анализа и взять его id.
        $sql = "INSERT INTO analysis_result (ate, tte, id_data_set) VALUES ('".$dataSet->result->ATE."', '".$dataSet->result->TTE."','".$dataSet->id."');";
        $res = mysqli_query($conn, $sql);
        $analysisResultId = mysqli_insert_id($conn);
        $dataSet->result->id = $analysisResultId;
        echo "<p> Айди результата: ".$analysisResultId."</p>"; 
        //Добавить в базу сущности описание_переменной.
        $sql = "";
        foreach ($dataSet->result->variableDescriptions as $variableDescription){
            $sql = $sql."INSERT INTO variable_description (id_result, id_variable, id_operator, value) VALUES ('".$variableDescription->result->id."','".$variableDescription->variable->id."','".$variableDescription->operator->id."','".$variableDescription->value."');";
        }
        $res = mysqli_query($conn, $sql);
        echo "<p> Добавлены ли описания переменных: ".$res."</p>";
        //Все сохранено в БД
        //Выбор id последнего добавленного объекта.
        $lastId = mysqli_insert_id($conn);
       
        return 1;
    }
    /**
     * 
     * @return списки типов и подтипов столбца данных.
     */
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
    public function GetResults($email){
         $conn = mysqli_connect($this->dbServername, $this->dbUsername, 
                $this->dbPassword, $this->dbName);
         $sql = "SELECT data_set.id, data_set.name,state_analysis.name,state_analysis.id FROM data_set INNER JOIN state_analysis ON data_set.id_state_analysis = state_analysis.id";
         $res = mysqli_query($conn, $sql);
         $nrows = mysqli_num_rows($res);
         if ($nrows == 0){
             return null;
         }else {
             $resultsArr = array();
             for ($i=0; $i<$nrows; $i++){
                 $row = mysqli_fetch_row($res);
                 $resultsArr[$i]['data_set_id'] = $row[0];
                 $resultsArr[$i]['data_set_name'] = $row[1];
                 $resultsArr[$i]['state_analysis_name'] = $row[2];
                 $resultsArr[$i]['state_analysis_id']=$row[3];
             }
             return $resultsArr;
         }
    }
    public function GetSpecificResult($dataSetId){
        $conn = mysqli_connect($this->dbServername, $this->dbUsername, 
                $this->dbPassword, $this->dbName);
        $sql = "select analysis_result.ate, analysis_result.tte, variable_description.value, data_column.name, operator.value "
             . " from (((data_set inner join analysis_result on data_set.id = analysis_result.id_data_set) inner join variable_description on analysis_result.id = variable_description.id_result ) inner join operator on variable_description.id_operator = operator.id) INNER join data_column on variable_description.id_variable = data_column.id "
             . " where data_set.id = ".$dataSetId." ";
        $res = mysqli_query($conn, $sql);
        $nrows = mysqli_num_rows($res);
        if ($nrows == 0){
            echo "<p> Null res</p>";
            return null;
        }else {
            $rows = array();
            for ($i = 0; $i<$nrows; $i++){
                $rows[$i] = mysqli_fetch_row($res);
            }
            
            $resultArr = array();
            $resultArr['ate'] = $rows[0][0];
            $resultArr['tte'] = $rows[0][1];
            $resultArr['vars'] = array();
            for ($i =0; $i<$nrows; $i++){
                $resultArr['vars'][$i]['var_name'] = $rows[$i][3];
                $resultArr['vars'][$i]['operator'] = $rows[$i][4];
                $resultArr['vars'][$i]['var_value'] = $rows[$i][2];
            }
        }
        return $resultArr;
    }
    public function Login($email){
        $conn = mysqli_connect($this->dbServername, $this->dbUsername, 
                $this->dbPassword, $this->dbName);
        $sql = "select email.email, company.id "
               ."from email inner join company on email.id_company=company.id "
               . "where email.email = ".$email."";
        $res = mysqli_query($conn, $sql);
        $nrows = mysqli_num_rows($res);
        if ($nrows == 0){
            $sql = "insert into email (email, id_company) values ('".$email."', '1')";
            $res = mysqli_query($conn, $sql);
            return 0;
        }else {
            return 1;
        }
    }
    
    
}
