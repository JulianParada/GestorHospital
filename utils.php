<?php
//Esta función crea un select con los valores y opciones de un arreglo
    function crearSelect($label, $nombreSelect, $opciones){
        $select = "<label for='$nombreSelect'><b>$label</b></label><br>";
        $select .= "<select name=$nombreSelect>";
        foreach($opciones as $value => $text){
            $select .= "<option value=$value>$text</option>";
        }
        $select .="</select>";
        return $select;
    }
?>