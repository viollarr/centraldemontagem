<?php
include"config.php";

$select = "SELECT * FROM repassando_nota WHERE id_montador = '".$_SESSION['id_montador']."' AND imprimir = '1'";
$query = mysql_query($select);
$rows = mysql_num_rows($query);

if($rows == 0){
	$texto = "A montadora não disponibilizou fichas para serem impressas.";
	$vale = "";
}
else{
	$texto = "A montadora disponibilizou $rows ficha(s) para fazer o donwload do arquivo(.doc) e imprimir em qualquer impressora.";
	$vale = "<tr><td width='100' align='center'>&nbsp;</td></tr><tr><td width='100' align='center'><input type='submit' value='Imprimir Vales' /></td></tr>";	
}
?>

<form action="emissao_vales.php" method="post" name="frm" enctype="multipart/form-data">
	<input type="hidden" value="<?=$_SESSION['id_montador'];?>" name="montador" />
    <table width=550 border=0 cellpadding=1 cellspacing=1 class='cor_tr'>
        <tr>
            <td class=titulo colspan=$colspan>:: Imprimir Vales Montagens Disponibilizados   ::</td>
        </tr>
        <tr>
            <td width='100' align='center'>&nbsp;</td>
        </tr>
        <tr>
            <td width='100'><?=$texto;?></td>
        </tr>
        <?=$vale;?>
        <tr>
            <td width='100' align='center'>&nbsp;</td>
        </tr>
    </table>
</form>
