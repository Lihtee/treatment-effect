<?php include $_SERVER['DOCUMENT_ROOT'] . "/Common/common.php"; ?>
<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/DBHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/AnalisysHandler.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/DataModel/DataSet.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/Classes/DataModel/DataColumn.php';
?>
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
            <input id="file" type="file" name="file" placeholder="Выберите файл" required>
            Использовать заголовки столбцов из файла?
            <input  id="useHeaders" type="checkbox" name ="useHeaders" placeholder="Хотите хранить результаты в базе?">
            <p>
                Выберите количество столбцов:
                <input type="number" name="numCol" id="numCol" required >
                <button type="button" id="loadDivs">Подтвердить количество столбцов</button>
            </p>
            <div id= "sections">
                <?php
                $dbHandler =
                        new DBHandler();
                $lists =
                        $dbHandler->GetCatalogs();
                $colSubtypes =
                        array();
                for ($i =
                0;
                        $i <
                        10;
                        $i++) {
                    echo "<div id='col" . $i . "' style='display:none'>"
                    . "<p> Столбец " . $i . " </p>"
                    . "<input type='text' name='colName" . $i . "' placeholder = 'Название столбца'>"
                    . "<select name = 'subtype" . $i . "' required>"
                    . "<option disabled>Выберите тип </option>";
                    foreach ($lists as
                            $type) {
                        foreach ($type->subtypes as
                                $subtype) {
                            echo "<option value = '" . $subtype->id . "'>" . $type->name . "-" . $subtype->name . " </option>";
                            $colSubtypes[$subtype->id] =
                                    $subtype;
                        }
                    }
                    echo "</select>";
                    echo "</div>";
                }
                ?>
            </div>
            <button type="submit" name="send" > Отправить данные на анализ</button>
        </form>
        <?php
        if (isset($_GET['send'])) {
            $dbHandler->DemoSave($_GET['file']);
            if (false){
                $numCol =
                        $_GET['numCol'];
                $colNames =
                        array();
                $colSubtypesId =
                        array();

                for ($i =
                0;
                        $i <
                        $numCol;
                        $i++) {
                    $colNames[$i] =
                            $_GET['colName' . $i];
                    $colSubtypesId[$i] =
                            $_GET['subtype' . $i];
                }

                //Save data set in db;
                if (isset($_GET['allowStorage'])) {

                }
                //Создание ассоциативного массива для передачи
                $dsArray =
                        array(
                    'description' => $_GET['file']);
                for ($i =
                0;
                        $i <
                        $numCol;
                        $i++) {
                    $dsArray['columns'][$i]['name'] =
                            $colNames[$i];
                    $dsArray['columns'][$i]['subtype'] =
                            $colSubtypes[$colSubtypesId[$i]];
                }
                //Старый метод создания стрктуры для передачи.
    //                $dataSet = new DataSet();
    //                $dataSet->description = $_GET['file'];
    //                for ($i =0; $i < $numCol; $i++){
    //                    $dataColumn = new DataColumn();
    //                    $dataColumn->name = $colNames[$i];
    //                    $dataColumn->subtype = $colSubtypes[$colSubtypesId[$i]];
    //                    $dataSet->AddDataColumn($dataColumn);
    //                }

                $analysisHandler =
                        new AnalisysHandler();
                //Отправляется описание набора данных + описания столбцов + файл.
                $res =
                        $analysisHandler->Analyse($_GET['file'],
                        $dsArray);

                $dbHandler->SaveDataSetResult($res,
                        $_SESSION['userEmail']);

        } 
        header("Location:../web/results.php");
        }
        ?>
    </body>
</html>
<script type="text/javascript">
    function ShowDivs() {

        var num = document.getElementById('numCol').value;
        for (var i = 0; i < num; i++) {
            var _div = document.getElementById('col' + i);
            _div.style.display = "";

        }
        for (var i = num; i < 10; i++) {
            var _div = document.getElementById('col' + i);
            _div.style.display = "none";

        }
    }
    var el = document.getElementById('loadDivs');
    el.addEventListener("click", ShowDivs);



    var control = document.getElementById("file");
    control.addEventListener("change", openFile);
    function openFile() {
        var files = control.files;
        if (files.length == 1) {
            var reader = new FileReader();
            reader.onload = function (event) {
                var content = event.target.result;
                var textToArray = event.target.result.split("\n").map(function (x)
                {
                    return x.split(",")
                });
                console.log(textToArray);
            }
            reader.readAsText(files[0]);


        }
    }

//    var headersControl = document.getElementById("useHeaders");
//    headersControl.control.addEventListener("change", useHeadersChanged);
////    function useHeadersChanged{
////        var a = new a();
////    }
</script>