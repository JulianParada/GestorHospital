<?php
//Esta función crea un select con los valores y opciones de un arreglo
    function crearSelect($label, $nombreSelect, $opciones){
        $select = "<label class=\"col-sm-2 col-form-label\" for='$nombreSelect'><b>$label</b></label>";
        $select .= "<div class=\"col-sm-4\">";
        $select .= "<select class=\"form-control\" name=$nombreSelect>";
        foreach($opciones as $value => $text){
            $select .= "<option value=$value>$text</option>";
        }
        $select .="</select>";
        $select .="</div>";
        return $select;
    }
?>