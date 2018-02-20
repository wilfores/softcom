<?php
include("../filtro.php");
?>
<?php
include("inicio.php");
include("cifrar.php");

?>
<script language="JavaScript">

function CopiaValor(objeto)
{
	document.ingreso.selecciona_tipo.value = objeto.value;
}

function Elegir()
{

         if (document.enviar.tipo[0].checked)
                     {
                        document.enviar.action="despachar.php";
                        document.enviar.submit();
                     }
                else
                    {
                        document.enviar.action="ingreso_recepcion.php";
                        document.enviar.submit();
                    }

}

function Retornar()
{
	document.enviar.action="ingreso_recepcion.php";
	document.enviar.submit();
}

</script>
<br />
<p class="fuente_titulo">
<center><b>Ingreso de correspondencia</b></center>
</p>
<br />
<CENTER>
<form name="enviar" method="POST">
<table>
<tr class="border_tr3">
<td align="center">
            <?php
           
             ?>
                <INPUT type="RADIO" name="tipo" value="0"  />
                <b>Desea Despachar</b>
                <INPUT type="RADIO" name="tipo" value="1" checked />
                <b>Despachar Despues</b>
            <?php
            
            ?>

<br>
</tr>

<tr>
<td colspan="2" align="center">
<br>
    <input class="boton" type="submit" name="envia" value="Aceptar" onClick="Elegir();">
    <input type="submit" name="cancelar" value="Cancelar" onClick="Retornar();" class="boton" />
<br><br>
</td>
</tr>
</table>
</form>
</CENTER>

<?php
include("final.php");
?>