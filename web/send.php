<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <p>Форма описания данных</p>
        <form method="GET">
            <input type="file" name="file" placeholder="Выберите файл" required>
            <input type="checkbox" name ="allowStorage" placeholder="Хотите хранить результаты в базе?">
            <p>
                Выберите количество столбцов:
                <input type="number" name="numCol" id="numCol" required >
                <button type="button" id="loadDivs">Подтвердить количество столбцов</button>
            </p>
            <div id= "sections">
                <?php
                    ini_set("display_errors",1);
                    error_reporting(E_ALL);
                    require_once '..\Classes\DBHandler.php';
                    $dbHandler = new DBHandler();
                    $lists = $dbHandler->GetCatalogs();
                    for ($i=0; $i<10; $i++){
                    echo "<div id='col".$i."' style='display:none'>"
                            ."<p> Столбец ".$i." </p>" 
                            . "<input type='text' name='colName".$i."' placeholder = 'Название столбца'>"
                            . "<select name = 'subtype".$i."' required>"
                            . "<option disabled>Выберите тип </option>";
                    foreach($lists as $type){
                        foreach ($type->subtypes as $subtype){
                            echo "<option value = '".$subtype->id."'>".$type->name."-".$subtype->name." </option>";
                        }
                    }
                    echo "</select>";
                    echo "</div>";
                    }
                ?>
            </div>
            <button type="submit" name="send"> Отправить данные на анализ</button>
        </form>
         <?php
            
            if (isset($_GET['submit'])){
                
                $numCol = $_GET['numCol'];
                $colNames = array();
                $colSubtypes = array();
                for ($i =0; $i<$numCol; $i++){
                    $colNames[$i] = $_GET['colName'.$i];  
                    $colSubtypes[$i] = $_GET['subtype'.$i];
                }
                
                //Save data set in db;
                if (isset($_GET['allowStorage'])){
                    
                }
                
                $colTypes = array();
                foreach ($colSubtypes as $subtypeId){
                    $i = 0;
                    foreach ($lists as $type){
                        foreach ($type->subtypes as $subtype){
                            if ($subtypeId == $subtype->id){
                                $colTypes[$i] = $type;
                            }
                        }
                    }
                    $i ++;
                }
                
                $dataSet = new DataSet();
                $dataSet->name = $_GET['file'];
                for ($i =0; $i < $numCol; $i++){
                    $dataColumn = new DataColumn();
                    $dataColumn->name = $colNames[$i];
                    $dataColumn->subtype = $colSubtypes[$i];
                    $dataSet->AddDataColumn($dataColumn);
                }
                
                $analysisHandler = new AnalisysHandler();
                $res = $analysisHandler->Analyse($file, $colTypes, $colNames);
                
               
                
            }
         ?>
    </body>
</html>
<script type="text/javascript">
    function ShowDivs(){
        
        var num = document.getElementById('numCol').value;
        for (var i =0; i<num; i++){
            var _div = document.getElementById('col'+i);
            _div.style.display = "";
            
        }
        for (var i = num; i<10; i++){
            var _div = document.getElementById('col'+i);
            _div.style.display = "none";
            
        }
    }
    var el = document.getElementById('loadDivs');
    el.addEventListener("click", ShowDivs);
</script>