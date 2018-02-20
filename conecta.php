<?php


function Conectarse3(){
        if(!($link=mysql_connect("localhost","root", "")))
        {
        echo"error conectando a la base de datos";
        exit(); 
        }

           if(!mysql_select_db("bd_softcom", $link))
            { echo"error selecionando BD";
              exit();         
            }
mysql_query ("SET NAMES 'utf8'");

        return $link;
}


function Desconectarse()
{
	mysql_close();
}
?>
