<?php

include_once "php/valida_sessao.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>CENTRAL DE MONTAGEM</title>

	<link rel="stylesheet" href="css/estilo.css" type="text/css" />

    <script type="text/javascript" src="js/jquery.js"></script>

 <script type="text/javascript">

	function getEndereco() {

			if($.trim($("#cep").val()) != ""){

				$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){

			  		if(resultadoCEP["resultado"]){

						$("#rua").val(unescape(resultadoCEP["tipo_logradouro"])+": "+unescape(resultadoCEP["logradouro"]));

						$("#bairro").val(unescape(resultadoCEP["bairro"]));

						$("#cidade").val(unescape(resultadoCEP["cidade"]));

						$("#estado").val(unescape(resultadoCEP["uf"]));

					}else{

						alert("Endere�o N&Atilde;O encontrado");

					}

				});				

			}			

	}

function barra(objeto){

		if (objeto.value.length == 2 || objeto.value.length == 5 ){

		objeto.value = objeto.value+"/";

		}

	}

function telefone(objeto){

		if (objeto.value.length == 4 || objeto.value.length == 5 ){

		objeto.value = objeto.value+"-";

		}

	}

function cep(objeto){

		if (objeto.value.length == 5 || objeto.value.length == 5 ){

		objeto.value = objeto.value+"-";

		}

	}

function validar(obj) { // recebe um objeto

    var s = (obj.value).replace(/\D/g,'');

    var tam=(s).length; // removendo os caracteres N&Atilde;O num�ricos

    if (!(tam==11 || tam==14)){ // validando o tamanho

        alert("'"+s+"' N&Atilde;O � um CPF ou um CNPJ válido!" ); // tamanho inválido

        return false;

    }

// se for CPF

    if (tam==11 ){

        if (!validaCPF(s)){ // chama a fun��o que valida o CPF

            alert("'"+s+"' N&Atilde;O � um CPF válido!" ); // se quiser mostrar o erro

            obj.select();  // se quiser selecionar o campo em quest�o

            return false;

        }

        obj.value=maskCPF(s);    // se validou o CPF mascaramos corretamente

        return true;

    }

// se for CNPJ

    if (tam==14){

        if(!validaCNPJ(s)){ // chama a fun��o que valida o CNPJ

            alert("'"+s+"' N&Atilde;O � um CNPJ válido!" ); // se quiser mostrar o erro

            obj.select();    // se quiser selecionar o campo enviado

            return false;

        }

        obj.value=maskCNPJ(s);    // se validou o CPF mascaramos corretamente

        return true;

    }

}

// fim da funcao validar()



// funo que valida CPF

// O algortimo de validao de CPF  baseado em clculos

// para o dgito verificador (os dois ltimos)

// No entrarei em detalhes de como funciona

function validaCPF(s) {

    var c = s.substr(0,9);

    var dv = s.substr(9,2);

    var d1 = 0;

    for (var i=0; i<9; i++) {

        d1 += c.charAt(i)*(10-i);

     }

    if (d1 == 0) return false;

    d1 = 11 - (d1 % 11);

    if (d1 > 9) d1 = 0;

    if (dv.charAt(0) != d1){

        return false;

    }

    d1 *= 2;

    for (var i = 0; i < 9; i++)    {

         d1 += c.charAt(i)*(11-i);

    }

    d1 = 11 - (d1 % 11);

    if (d1 > 9) d1 = 0;

    if (dv.charAt(1) != d1){

        return false;

    }

    return true;

}



function validaCNPJ(CNPJ) {

    var a = new Array();

    var b = new Number;

    var c = [6,5,4,3,2,9,8,7,6,5,4,3,2];

    for (i=0; i<12; i++){

        a[i] = CNPJ.charAt(i);

        b += a[i] * c[i+1];

    }

    if ((x = b % 11) < 2) { a[12] = 0 } else { a[12] = 11-x }

    b = 0;

    for (y=0; y<13; y++) {

        b += (a[y] * c[y]);

    }

    if ((x = b % 11) < 2) { a[13] = 0; } else { a[13] = 11-x; }

    if ((CNPJ.charAt(12) != a[12]) || (CNPJ.charAt(13) != a[13])){

        return false;

    }

    return true;

}





    // Funo que permite apenas teclas numricas

    // Deve ser chamada no evento onKeyPress desta forma

    // return (soNums(event));

function soNums(e)

{

    if (document.all){var evt=event.keyCode;}

    else{var evt = e.charCode;}

    if (evt <20 || (evt >47 && evt<58)){return true;}

    return false;

}



//    funo que mascara o CPF

function maskCPF(CPF){

    return CPF.substring(0,3)+"."+CPF.substring(3,6)+"."+CPF.substring(6,9)+"-"+CPF.substring(9,11);

}1

//    fun��o que mascara o CNPJ

function maskCNPJ(CNPJ){

    return CNPJ.substring(0,2)+"."+CNPJ.substring(2,5)+"."+CNPJ.substring(5,8)+"/"+CNPJ.substring(8,12)+"-"+CNPJ.substring(12,14);

}1





function ValidaEmail()

{

  var obj = eval("document.forms[0].email");

  var txt = obj.value;

  if ((txt.length != 0) && ((txt.indexOf("@") < 1) || (txt.indexOf('.') < 1)))

  {

    alert('Email incorreto');

	obj.focus();

  }

}

</script>

	<script type="text/javascript" src="js/funcoes.js"></script>

   	<script language="javascript">	

			function nu(campo){

				var digits="0123456789"

				var campo_temp 

				for (var i=0;i<campo.value.length;i++){

					campo_temp=campo.value.substring(i,i+1) 

					if (digits.indexOf(campo_temp)==-1){

						campo.value = campo.value.substring(0,i);

						break;

					}

				}

			}

    </script>

<script language="javascript" type="text/javascript">

		

	$(document).ready(function(){

		$("input[name=n_montagem]").change(function(){

			$("#n_montagem").html('CARREGANDO...');

			$.post('busca_n_montagens.php',

			{n_montagem:$(this).val()},

			function(valor){

				$("#n_montagem").html(valor);

			}

			)

		})

		$("input[name=cod_cliente]").keyup(function(){

			$("#produtos").html('CARREGANDO...');

			$.post('busca_produtos.php',

			{cod_produto:$(this).val()},

			function(valor){

				$("#produtos").html(valor);

			}

			)

		})

		$("input[name=cod_cliente2]").keyup(function(){

			$("#produtos2").html('CARREGANDO...');

			$.post('busca_produtos2.php',

			{cod_produto2:$(this).val()},

			function(valor){

				$("#produtos2").html(valor);

			}

			)

		})

		$("input[name=cod_cliente3]").keyup(function(){

			$("#produtos3").html('CARREGANDO...');

			$.post('busca_produtos3.php',

			{cod_produto3:$(this).val()},

			function(valor){

				$("#produtos3").html(valor);

			}

			)

		})

		$("input[name=cod_cliente4]").keyup(function(){

			$("#produtos4").html('CARREGANDO...');

			$.post('busca_produtos4.php',

			{cod_produto4:$(this).val()},

			function(valor){

				$("#produtos4").html(valor);

			}

			)

		})

		$("input[name=cod_cliente5]").keyup(function(){

			$("#produtos5").html('CARREGANDO...');

			$.post('busca_produtos5.php',

			{cod_produto5:$(this).val()},

			function(valor){

				$("#produtos5").html(valor);

			}

			)

		})

		$("input[name=cod_cliente6]").keyup(function(){

			$("#produtos6").html('CARREGANDO...');

			$.post('busca_produtos6.php',

			{cod_produto6:$(this).val()},

			function(valor){

				$("#produtos6").html(valor);

			}

			)

		})

	})

</script>

<script>



function alteraClasse(id, modulo)

{

          if(modulo.checked)

                  document.getElementById(id).className = "blockOff";

        

        else

                document.getElementById(id).className = "blockOn";

}



</script>

</head>





<body>

<?php //include_once "inc_topo.php"; ?>

<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu.php"; ?></td>

    <td width="578" valign="top">

	<form action="php/inc_cad_clientes.php" method="post" id="teste"  name="frm_servico">

	<table width="570" border="0" align="center" cellpadding="2" cellspacing="1" class="texto cor_tr">

      <tr>

        <td colspan="4" align="center" bgcolor="#FFFFFF"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /></td>

        <script language="javascript">addCampos('salvar');</script>

      </tr>

	  <tr>

		<td colspan="4" class="titulo">Cadastro de Clientes</td>

	  </tr>

      <tr>

      	<td width="101"><strong>Prioridade</strong>: </td>

        <td width="227" colspan="3">

        	<input type="checkbox" name="nor" id="nor" checked="checked" value="0" /><strong>Normal</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

        	<script language="javascript">addCampos('nor');</script>

            <input type="checkbox" name="agen" id="agen" value="1" onclick="alteraClasse('tbCk1', this)" /><strong>Agendamento</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

            <script language="javascript">addCampos('agen');</script>

            <input type="checkbox" name="jur" id="jur" value="2" /><strong>Jur&iacute;dico</strong>

            <script language="javascript">addCampos('jur');</script>

        </td>

      </tr>

      <tr>

      	<td colspan="4" align="left">

        	<table id="tbCk1" width="80%" class="blockOn">

      			<tr>

      				<td align="left">Data do Agendamento:&nbsp;&nbsp;

                        <input type="text" name="data_agendamento" id="data_agendamento" size="15" maxlength="10" value="dd/mm/aaaa" onkeyup="barra(this)" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                        Hora:

                        <select name="hora">

                            <option value="COMERCIAL">COMERCIAL</option>

                            <option value="MANH�">MANH�</option>

                            <option value="TARDE">TARDE</option>

                        </select>

                    </td>

              </tr>

           </table>

        </td>

      </tr>

      <tr><td colspan="4">&nbsp;</td></tr>

      <tr>

      	<td width="101">N&deg; Ordem de Montagem*:</td>

        <td width="227"><input type="text" size="20" name="n_montagem" id="n_montagem" tabindex="1" onKeyUp="nu(this)" /><div id="n_montagem"></div></td>

        <script language="javascript">addCampos('n_montagem');</script>

      	<td width="131">Loja*:</td>

        <td width="332"><input type="text" size="5" maxlength="2" name="cod_loja" id="cod_loja" tabindex="2" onchange="this.value = this.value.toUpperCase();" /></td>

        <script language="javascript">addCampos('cod_loja');</script>

      </tr>

      <tr>

      	<td>Or&ccedil;amento*:</td>

        <td width="227"><input type="text" size="20" name="orcamento" id="orcamento" tabindex="3" onKeyUp="nu(this)" /></td>

        <script language="javascript">addCampos('orcamento');</script>

      	<td>Data Faturamento*:</td>

        <td width="227"><input type="text" size="15" maxlength="10" name="data_faturamento" id="data_faturamento" tabindex="4" onkeyup="barra(this)" /></td>

        <script language="javascript">addCampos('data_faturamento');</script>

      </tr>

      <tr>

        <td width="104" align="left">Nome Completo*: </td>

        <td align="left"><input type="text" size="35" name="nome_cliente" id="nome_cliente" tabindex="5" onkeyup="this.value = this.value.toUpperCase();" /></td>

        <script language="javascript">addCampos('nome_cliente');</script>

        <td align="left">CEP: </td>

      	<td align="left"><input name="cep" id="cep" size="10" maxlength="8" onKeyUp="nu(this)" onBlur="getEndereco()" tabindex="6" /></td>

        <script language="javascript">addCampos('cep');</script>

      </tr>

      <tr>

        <td align="left">Endere&ccedil;o: </td>

        <td align="left" colspan="3"><input name="rua" id="rua" size="60"  tabindex="7" onkeydown="this.value = this.value.toUpperCase();"/></td>

        <script language="javascript">addCampos('rua');</script>

      </tr>

      <tr>

      	<td align="left">N&deg; :</td>

		<td align="left" colspan="3"><input type="text" name="numero" id="numero" size="5" tabindex="8" />

        <script language="javascript">addCampos('numero');</script>&nbsp;&nbsp;&nbsp;

        Comp.:	<input type="text" name="comp" id="comp" size="10" tabindex="9" onkeyup="this.value = this.value.toUpperCase();" /></td>

        <script language="javascript">addCampos('comp');</script>

  	  </tr>

      <tr>

        <td align="left">Bairro*: </td>

        <td align="left" colspan="3"><input name="bairro" id="bairro" size="20" tabindex="10" onkeydown="this.value = this.value.toUpperCase();" />

        <script language="javascript">addCampos('bairro');</script>

        &nbsp;Cidade:&nbsp;<input name="cidade" id="cidade" size="13" tabindex="11" onkeydown="this.value = this.value.toUpperCase();" />

        <script language="javascript">addCampos('cidade');</script>

        &nbsp;Estado:&nbsp;<input name="estado" id="estado" size="2" maxlength="2" tabindex="12" onkeyup="this.value = this.value.toUpperCase();" /></td>

        <script language="javascript">addCampos('estado');</script>

      </tr>

      <tr>

        <td align="left">Telefone1: </td>

        <td align="left" colspan="3"><input type="text" name="res" id="res" size="13" maxlength="9" onKeyUp="telefone(this)" tabindex="13" />

        <script language="javascript">addCampos('res');</script>

        &nbsp;&nbsp;Telefone2:&nbsp;<input type="text" name="res2" id="res2" size="13" maxlength="9" onKeyUp="telefone(this)" tabindex="14" />

        <script language="javascript">addCampos('res2');</script>

        &nbsp;&nbsp;Telefone3:&nbsp;<input type="text" name="res3" id="res3" size="13" maxlength="9" onKeyUp="telefone(this)" tabindex="15" /></td>

        <script language="javascript">addCampos('res3');</script>

      </tr>

      <tr>

    	<td colspan="4">

        	Ponto de Refer&ecirc;ncia:<br />

            <textarea name="referencia_cliente" rows="5" cols="40" tabindex="16" onkeyup="this.value = this.value.toUpperCase();"></textarea>

            <script language="javascript">addCampos('referencia_cliente');</script>

        </td>

        <tr>

        	<td colspan="4">&nbsp;</td>

        </tr>

        <tr>

        	<td><strong>PRODUTOS</strong></td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente" id="qtde_cliente" size="2" tabindex="17" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente" id="cod_cliente" size="5" tabindex="18"  onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos"></span>

            <script language="javascript">addCampos('produto_cliente');</script>

            </td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente2" id="qtde_cliente2" size="2" tabindex="20" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente2');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente2" id="cod_cliente2" size="5" tabindex="21" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente2');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos2"></span>

            <script language="javascript">addCampos('produto_cliente2');</script>

            </td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente3" id="qtde_cliente3" size="2" tabindex="23" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente3');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente3" id="cod_cliente3" size="5" tabindex="24" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente3');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos3"></span>

            <script language="javascript">addCampos('produto_cliente3');</script>

            </td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente4" id="qtde_cliente4" size="2" tabindex="25" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente4');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente4" id="cod_cliente4" size="5" tabindex="26" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente4');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos4"></span>

            <script language="javascript">addCampos('produto_cliente4');</script>

            </td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente5" id="qtde_cliente5" size="2" tabindex="28" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente5');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente5" id="cod_cliente5" size="5" tabindex="29" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente5');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos5"></span>

            <script language="javascript">addCampos('produto_cliente5');</script>

            </td>

        </tr>

        <tr>

        	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente6" id="qtde_cliente6" size="2" tabindex="28" onkeyup="nu(this)" />

            <script language="javascript">addCampos('qtde_cliente6');</script>

            &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente6" id="cod_cliente6" size="5" tabindex="29" onkeyup="this.value = this.value.toUpperCase();" />

            <script language="javascript">addCampos('cod_cliente6');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos6"></span>

            <script language="javascript">addCampos('produto_cliente6');</script>

            </td>

        </tr>

        <tr>

        	<td colspan="4">&nbsp;</td>

        </tr>

        <tr>

        	<td colspan="4">&nbsp;</td>

        </tr>

        <tr>

        	<td colspan="4">* Campos de preenchimento <strong>OBRIGATÓRIO</strong>!</td>

        </tr>

      </tr>

    </table>

	</form>

	</td>

  </tr>

</table>

<?php include_once "inc_rodape.php"; ?>

</body>

</html>