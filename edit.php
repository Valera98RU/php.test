<?php
include_once("objects/position.php");
include_once("objects/employee.php");
include_once("config/database.php");
session_start();

$db = new DataBase;
$db = $db->getConnection();
$position = new Position($db);

$employeLab = new Employee($db); 

$employeer = $employeLab->getOneEmployee($_SESSION["id"]);
$positionList = $position->getPOsitionList();



?>  
<div id="editForm" class="form-popup card-body" >
    
        <table>
            <button onclick="closeForm()" class="btn btn-primary"> X</button>
            <tr>
                <td><label for="#name"> ФИО</label></td>
                <td><input type="text" value = "<? echo $employeer["name"]?>" name="name" id="name"></td>
            </tr>
            <tr>
                <td>Должность</td>
                <td>
                    <select name="positions" id="position">
                        <option disable> Выбирете должность</option>
                        <?  
                            foreach($positionList as $pos){
                                $html_string = "<option";
                                if($employeer["id_position"] == $pos["id"]){
                                    $html_string.=" selected ";
                                }
                                $html_string .= " value='".$pos["id"]."'>".$pos["name"]."</option>";

                                echo $html_string;
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td>Дата трудоустройства</td>
                <td><input type="date" name="date" id="date" value="<? echo $employeer["date_employment"]?>"></td>
            </tr>
            <tr>
                <td>Уволен</td>
                <td><input type="checkbox" name="state" id="state-checkbox"  <?
                 if($employeer["state"]=="1"){
                     echo " checked";
                    }
                     ?>></td>
            </tr>
            <tr>
                <td colspan="2"><input type="button" value="save" class="btn btn-primary" name="save" id="<?echo $_SESSION["id"];?>" onclick="savePerson()"></td>
            </tr>
        </table>
        
    
</div>
