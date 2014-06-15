<?php
include"config.php";

$y = mysql_query("SELECT * FROM usuarios WHERE id = '".$_GET['id']."'");
if ($x = mysql_fetch_array($y))

{
if($x['tipo'] == '1'){$checked1 = 'selected="selected"';}
elseif($x['tipo'] == '2'){$checked2 = 'selected="selected"';}
elseif($x['tipo'] == '3'){$checked3 = 'selected="selected"';}
elseif($x['tipo'] == '4'){$checked4 = 'selected="selected"';}
elseif($x['tipo'] == '5'){$checked5 = 'selected="selected"';}

?>
<form name="form1" method="post" action="php/alterar_db_usuario.php?id=<?=$x[id]?>">
 <input type="hidden" name="editar_usuario" value="1" />
	<input type="hidden" name="id_usuario" value="<?=$x[id]?>" />
	<input type="hidden" name="ip" value="<?=$x[ip]?>" />
	<input type="hidden" name="data" value="<?=$x[data]?>" />
	<input type="hidden" name="hora" value="<?=$x[hora]?>" />
<table width="550" border="0" align="center" cellpadding="2" cellspacing="2" class="cor_tr texto">
          <tr>
		    <td align="center" bgcolor="#FFFFFF" colspan="2"><input type="image" src="images/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /></td>
            <script language="javascript">addCampos('salvar');</script>
          </tr>
		  <tr>
            <td align="center" class="titulo" colspan="2">Visualizar Usuário</td>
          </tr>
          <tr>
            <td>Tipo Usuário:</td>
            <td>
                <select name="tipo">                
                    <option value="1" <?=$checked1?> >Administrador</option>
                    <option value="3" <?=$checked3?> >Funcionário RH</option>
                    <option value="2" <?=$checked2?> >Funcionário</option>
                    <option value="5" <?=$checked5?> >Montador</option>
                    <option value="4" <?=$checked4?> >Visitante</option>
                </select>
                <script language="javascript">addCampos('tipo');</script>
            </td>
          </tr>
          <?php
		  	if($_SESSION['login'] == 'narcizo'){
		  ?>
          <tr>
            <td>Acesso Externo:</td>
            <td>
            	<input type="radio" value="sim" name="acesso_externo" <?php echo ($x['acesso_externo'] == 'sim')? 'checked="checked"':''; ?> />Sim&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" value="nao" name="acesso_externo" <?php echo ($x['acesso_externo'] == 'nao')? 'checked="checked"':''; ?> />N&atilde;o
                <script language="javascript">addCampos('acesso_externo');</script>
            </td>
          </tr>
          <?php
			}
		  ?>
          <tr>
            <td>Nome: </td>
            <td><input name="nome" type="text" id="nome"value="<?=$x[nome]?>" size="30" maxlength="10" />
             <script language="javascript">addCampos('nome');</script>
            </td>
          </tr>
		  <tr>
			<td>E-mail:</td>
			<td><input name="email" value="<?=$x[email]?>" type="text" id="email" size="20" /></td>
            <script language="javascript">addCampos('email');</script>
		  </tr>
		  <tr>
			<td>Login:</td>
			<td><input name="login" value="<?=$x[login]?>" type="text" id="login" size="20" /></td>
            <script language="javascript">addCampos('login');</script>
		  </tr>
		  <tr>
			<td>Senha:</td>
			<td><input name="senha" value="<?=$x[senha]?>" type="password" id="senha" size="20" /></td>
            <script language="javascript">addCampos('senha');</script>
		  </tr>
		 <tr>
		<td align="center" colspan="2"><a href="javascript:history.go(-1)">Voltar</a></td>
		</tr>
        </table>
		</form>		
<?php
}
?>