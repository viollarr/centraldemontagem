<?php

include"config.php";



$select_query = "SELECT c.id_cliente, c.n_montagem, c.orcamento, c.nome_cliente FROM clientes_assistencia c WHERE c.ativo = '0' ORDER BY c.nome_cliente ASC ";

$sql = mysql_query($select_query);

$total = mysql_num_rows($sql); // Esta função irá retornar o total de linhas na tabela

?>

<table width=550 border=0 cellpadding=1 cellspacing=1>

    <tr>

        <td class="titulo" colspan="2" >:: Validar Clientes do Arquivo ::</td>

    </tr>

    <tr colspan="2"><td>&nbsp;</td></tr>

    <tr>

        <td class="texto" width="100" colspan="2">&nbsp;</td>

    </tr>

    <tr>

        <td class="texto" align="center">Existe <?=$total?> fichas para validar clique no bot&atilde;o para valid&aacute;-las.</td>

        <td align="left">

            <form action="php/validar_clientes.php" enctype="multipart/form-data" method="post">

                <input type="hidden" name="vld" value="1" />

                <input type="hidden" name="quem_cadastra" value="<?=$_SESSION['id_usuario']?>" />

                <input type="submit" value="Validar Fichas" />

            </form>

        </td>

    </tr>				

</table>