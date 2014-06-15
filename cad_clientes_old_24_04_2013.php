<?php

include_once "php/valida_sessao.php";

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>NAEC - PRESTY-RIO</title>
    <link rel="stylesheet" href="css/estilo.css" type="text/css" />
    <link rel="stylesheet" href="js/datepiker/themes/base/jquery.ui.all.css" type="text/css" />
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="js/datepiker/ui/jquery.ui.core.js" type="text/javascript"></script>
    <script src="js/datepiker/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
    <script src="js/datepiker/ui/i18n/jquery.ui.datepicker-pt-BR.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
    <script type="text/javascript">
      //função que inicia o datepicker
      jQuery(function($) {
            $(".datepicker").datepicker( $.datepicker.regional[ "pt-BR" ] );
            $(".telefone").mask("(99)9999-9999");
      		$(".data").mask("99/99/9999");
      });
    </script>
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

						alert("Endere&ccedil;o N&Atilde;O encontrado");

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
       alert("'"+s+"' N&Atilde;O &eacute; um CPF ou um CNPJ válido!" ); // tamanho inválido
       return false;
   }

// se for CPF
   if (tam==11 ){
       if (!validaCPF(s)){ // chama a fun��o que valida o CPF
           alert("'"+s+"' N&Atilde;O &eacute; um CPF válido!" ); // se quiser mostrar o erro
           obj.select();  // se quiser selecionar o campo em quest�o
           return false;
       }
       obj.value=maskCPF(s);    // se validou o CPF mascaramos corretamente
       return true;
   }

// se for CNPJ
   if (tam==14){
       if(!validaCNPJ(s)){ // chama a fun��o que valida o CNPJ
           alert("'"+s+"' N&Atilde;O &eacute; um CNPJ válido!" ); // se quiser mostrar o erro
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

		$("input[name=cod_cliente7]").keyup(function(){

			$("#produtos7").html('CARREGANDO...');

			$.post('busca_produtos7.php',

			{cod_produto7:$(this).val()},

			function(valor){

				$("#produtos7").html(valor);

			}

			)

		})

		$("input[name=cod_cliente8]").keyup(function(){

			$("#produtos8").html('CARREGANDO...');

			$.post('busca_produtos8.php',

			{cod_produto8:$(this).val()},

			function(valor){

				$("#produtos8").html(valor);

			}

			)

		})

		$("input[name=cod_cliente9]").keyup(function(){

			$("#produtos9").html('CARREGANDO...');

			$.post('busca_produtos9.php',

			{cod_produto9:$(this).val()},

			function(valor){

				$("#produtos9").html(valor);

			}

			)

		})

		$("input[name=cod_cliente10]").keyup(function(){

			$("#produtos10").html('CARREGANDO...');

			$.post('busca_produtos10.php',

			{cod_produto10:$(this).val()},

			function(valor){

				$("#produtos10").html(valor);

			}

			)

		})

		$("input[name=cod_cliente11]").keyup(function(){

			$("#produtos11").html('CARREGANDO...');

			$.post('busca_produtos11.php',

			{cod_produto11:$(this).val()},

			function(valor){

				$("#produtos11").html(valor);

			}

			)

		})

		$("input[name=cod_cliente12]").keyup(function(){

			$("#produtos12").html('CARREGANDO...');

			$.post('busca_produtos12.php',

			{cod_produto12:$(this).val()},

			function(valor){

				$("#produtos12").html(valor);

			}

			)

		})

		$("input[name=cod_cliente13]").keyup(function(){

			$("#produtos13").html('CARREGANDO...');

			$.post('busca_produtos13.php',

			{cod_produto13:$(this).val()},

			function(valor){

				$("#produtos13").html(valor);

			}

			)

		})

		$("input[name=cod_cliente14]").keyup(function(){

			$("#produtos14").html('CARREGANDO...');

			$.post('busca_produtos14.php',

			{cod_produto14:$(this).val()},

			function(valor){

				$("#produtos14").html(valor);

			}

			)

		})

		$("input[name=cod_cliente15]").keyup(function(){

			$("#produtos15").html('CARREGANDO...');

			$.post('busca_produtos15.php',

			{cod_produto15:$(this).val()},

			function(valor){

				$("#produtos15").html(valor);

			}

			)

		})

		$("input[name=cod_cliente16]").keyup(function(){

			$("#produtos16").html('CARREGANDO...');

			$.post('busca_produtos16.php',

			{cod_produto16:$(this).val()},

			function(valor){

				$("#produtos16").html(valor);

			}

			)

		})

		$("input[name=cod_cliente17]").keyup(function(){

			$("#produtos17").html('CARREGANDO...');

			$.post('busca_produtos17.php',

			{cod_produto17:$(this).val()},

			function(valor){

				$("#produtos17").html(valor);

			}

			)

		})

		$("input[name=cod_cliente18]").keyup(function(){

			$("#produtos18").html('CARREGANDO...');

			$.post('busca_produtos18.php',

			{cod_produto18:$(this).val()},

			function(valor){

				$("#produtos18").html(valor);

			}

			)

		})

		$("input[name=cod_cliente19]").keyup(function(){

			$("#produtos19").html('CARREGANDO...');

			$.post('busca_produtos19.php',

			{cod_produto19:$(this).val()},

			function(valor){

				$("#produtos19").html(valor);

			}

			)

		})

		$("input[name=cod_cliente20]").keyup(function(){

			$("#produtos20").html('CARREGANDO...');

			$.post('busca_produtos20.php',

			{cod_produto20:$(this).val()},

			function(valor){

				$("#produtos20").html(valor);

			}

			)

		})		

	})

</script>

</head>
<body>

<?php //include_once "inc_topo.php"; ?>

<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
 <tr>
   <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu.php"; ?></td>
   <td width="578" valign="top">

	<form action="php/inc_cad_clientes.php" method="post" id="teste"  name="frm_servico">
   <input type="hidden" name="quem_cadastra" value="<?=$_SESSION['id_usuario']?>" />

	<table width="570" border="0" align="center" cellpadding="2" cellspacing="1" class="texto cor_tr">
     <tr>
       <td colspan="4" align="center" bgcolor="#FFFFFF"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /></td>
       <script language="javascript">addCampos('salvar');</script>
     </tr>

	  <tr>

		<td colspan="4" class="titulo">Cadastro de Clientes</td>

	  </tr>
    	 <tr>
         	<td align="left"><strong>Empresa</strong>:</td>
			<td colspan="3">
				<input type="radio" checked="checked" name="empresa" value="1" /><strong>WA(RJ)</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="empresa" value="5" /><strong>WA(BA)</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="radio" name="empresa" value="4" /><strong>RE(BA)</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<br />
                <input type="radio" name="empresa" value="2" /><strong>RE(RJ)</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="radio" name="empresa" value="3" /><strong>Competição</strong>
				<script language="javascript">addCampos('empresa');</script>
			</td>
         </tr>
     <tr><td colspan="4">&nbsp;</td></tr>
     <tr>
     	<td width="101"><strong>Prioridade</strong>: </td>
       <td width="227" colspan="3">
       	<input type="radio" name="prioridade" id="prioridade" checked="checked" value="0" /><strong>NORMAL</strong>&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="radio" name="prioridade" id="prioridade" value="2" /><strong>JUSTI&Ccedil;A</strong>&nbsp;&nbsp;&nbsp;&nbsp;
           <input type="radio" name="prioridade" id="prioridade" value="4" /><strong>LOJA</strong>
           <script language="javascript">addCampos('prioridade');</script>
       </td>
     </tr>
     <tr><td colspan="4">&nbsp;</td></tr>
     <tr>
     	<td align="left" colspan="4">
       	<input type="radio" name="tipo" checked="checked" value="0" /> Montagem<br />
           <input type="radio" name="tipo" value="1" /> Desmontagem<br />
           <input type="radio" name="tipo" value="2" /> Revis&atilde;o<br />
           <input type="radio" name="tipo" value="3" /> T&eacute;cnica<br />
       </td>
     </tr>
     <tr><td colspan="4">&nbsp;</td></tr>
	  <tr>
      		<td colspan="2" style="color:#FF0000">Data Recebimento (NAEC)*:</td>
           <td colspan="2">
           	<input type="text" size="15" maxlength="10" tabindex="1" name="data_recebimento" id="data_recebimento" class="data datepicker" />
            </td>
                   <script language="javascript">addCampos('data_recebimento');</script>
     </tr>
     <tr><td colspan="4">&nbsp;</td></tr>
     <tr>
     	<td width="101">N&deg; Ordem de Montagem*:</td>
       <td width="227"><input type="text" size="20" name="n_montagem" id="n_montagem" tabindex="2" onKeyUp="nu(this)" /><div id="n_montagem"></div></td>
       <script language="javascript">addCampos('n_montagem');</script>
     	<td width="131">Loja*:</td>
       <td width="332"><input type="text" size="5" maxlength="3" name="cod_loja" id="cod_loja" tabindex="3" onchange="this.value = this.value.toUpperCase();" /></td>
       <script language="javascript">addCampos('cod_loja');</script>
     </tr>
     <tr>
     	<td>Orçamento*:</td>
       <td width="227"><input type="text" size="20" name="orcamento" id="orcamento" tabindex="4" onKeyUp="nu(this)" /></td>
       <script language="javascript">addCampos('orcamento');</script>
     	<td>Data Faturamento*:</td>
       <td width="227"><input type="text" size="15" maxlength="10" name="data_faturamento" id="data_faturamento" tabindex="5" class="data datepicker" /></td>
       <script language="javascript">addCampos('data_faturamento');</script>
     </tr>
     <tr>
     	<td>Vendedor:</td>
       <td width="227"><input type="text" size="35" name="vendedor" id="vendedor" tabindex="6" onkeyup="this.value = this.value.toUpperCase();" /></td>
       <script language="javascript">addCampos('vendedor');</script>
     	<td>Nota Fiscal:</td>
       <td width="227"><input type="text" size="20" name="notaFiscal" id="notaFiscal" tabindex="7" /></td>
       <script language="javascript">addCampos('notaFiscal');</script>
     </tr>
     <tr>
       <td width="104" align="left">Nome Completo*: </td>
       <td align="left"><input type="text" size="35" name="nome_cliente" id="nome_cliente" tabindex="8" onkeyup="this.value = this.value.toUpperCase();" /></td>
       <script language="javascript">addCampos('nome_cliente');</script>
       <td align="left">CEP: </td>
     	<td align="left"><input name="cep" id="cep" size="10" maxlength="8" onKeyUp="nu(this)" onBlur="getEndereco()" tabindex="9" /></td>
       <script language="javascript">addCampos('cep');</script>
     </tr>
     <tr>
       <td align="left">Endere&ccedil;o: </td>
       <td align="left" colspan="3"><input name="rua" id="rua" size="60"  tabindex="10" onkeydown="this.value = this.value.toUpperCase();"/></td>
       <script language="javascript">addCampos('rua');</script>
     </tr>
     <tr>
     	<td align="left">N&deg; :</td>

		<td align="left" colspan="3"><input type="text" name="numero" id="numero" size="5" tabindex="11" />
       <script language="javascript">addCampos('numero');</script>&nbsp;&nbsp;&nbsp;
       Comp.:	<input type="text" name="comp" id="comp" size="10" tabindex="12" onkeyup="this.value = this.value.toUpperCase();" /></td>
       <script language="javascript">addCampos('comp');</script>
 	  </tr>
     <tr>
       <td align="left">Bairro*: </td>
       <td align="left" colspan="3"><input name="bairro" id="bairro" size="20" tabindex="13" onkeydown="this.value = this.value.toUpperCase();" />
       <script language="javascript">addCampos('bairro');</script>
       &nbsp;Cidade:&nbsp;<input name="cidade" id="cidade" size="17" tabindex="14" onkeydown="this.value = this.value.toUpperCase();" />
       <script language="javascript">addCampos('cidade');</script>
       &nbsp;Estado:&nbsp;<input name="estado" id="estado" size="2" maxlength="2" tabindex="15" onkeyup="this.value = this.value.toUpperCase();" /></td>
       <script language="javascript">addCampos('estado');</script>
     </tr>
     <tr>
       <td align="left">Telefone1: </td>
       <td align="left" colspan="3"><input type="text" name="res" id="res" size="13" maxlength="14" class="telefone" tabindex="16" />
       <script language="javascript">addCampos('res');</script>
       &nbsp;&nbsp;Telefone2:&nbsp;<input type="text" name="res2" id="res2" size="13" maxlength="14" class="telefone" tabindex="17" />
       <script language="javascript">addCampos('res2');</script>
       &nbsp;&nbsp;Telefone3:&nbsp;<input type="text" name="res3" id="res3" size="13" maxlength="14" class="telefone" tabindex="18" /></td>
       <script language="javascript">addCampos('res3');</script>
     </tr>
     <tr>
   	<td colspan="4">
       	Ponto de Refer&ecirc;ncia:<br />
           <textarea name="referencia_cliente" rows="5" cols="40" tabindex="19" onkeyup="this.value = this.value.toUpperCase();"></textarea>
           <script language="javascript">addCampos('referencia_cliente');</script>
       </td>
       <tr>
       	<td colspan="4">&nbsp;</td>
       </tr>
       <tr>
       	<td colspan="4" align="left"><strong>PRODUTOS</strong></td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente" id="qtde_cliente" size="2" tabindex="20" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente" id="cod_cliente" size="5" tabindex="21"  onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos"></span>
           <script language="javascript">addCampos('produto_cliente');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente2" id="qtde_cliente2" size="2" tabindex="22" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente2');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente2" id="cod_cliente2" size="5" tabindex="23" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente2');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos2"></span>
           <script language="javascript">addCampos('produto_cliente2');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente3" id="qtde_cliente3" size="2" tabindex="24" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente3');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente3" id="cod_cliente3" size="5" tabindex="25" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente3');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos3"></span>
           <script language="javascript">addCampos('produto_cliente3');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente4" id="qtde_cliente4" size="2" tabindex="26" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente4');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente4" id="cod_cliente4" size="5" tabindex="27" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente4');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos4"></span>
           <script language="javascript">addCampos('produto_cliente4');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente5" id="qtde_cliente5" size="2" tabindex="29" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente5');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente5" id="cod_cliente5" size="5" tabindex="30" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente5');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos5"></span>
           <script language="javascript">addCampos('produto_cliente5');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente6" id="qtde_cliente6" size="2" tabindex="32" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente6');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente6" id="cod_cliente6" size="5" tabindex="33" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente6');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos6"></span>
           <script language="javascript">addCampos('produto_cliente6');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente7" id="qtde_cliente7" size="2" tabindex="35" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente7');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente7" id="cod_cliente7" size="5" tabindex="36" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente7');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos7"></span>
           <script language="javascript">addCampos('produto_cliente7');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente8" id="qtde_cliente8" size="2" tabindex="38" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente8');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente8" id="cod_cliente8" size="5" tabindex="39" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente8');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos8"></span>
           <script language="javascript">addCampos('produto_cliente8');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente9" id="qtde_cliente9" size="2" tabindex="41" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente9');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente9" id="cod_cliente9" size="5" tabindex="42" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente9');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos9"></span>
           <script language="javascript">addCampos('produto_cliente9');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente10" id="qtde_cliente10" size="2" tabindex="44" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente10');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente10" id="cod_cliente10" size="5" tabindex="45" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente10');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos10"></span>
           <script language="javascript">addCampos('produto_cliente10');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente11" id="qtde_cliente11" size="2" tabindex="47" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente11');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente11" id="cod_cliente11" size="5" tabindex="48" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente11');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos11"></span>
           <script language="javascript">addCampos('produto_cliente11');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente12" id="qtde_cliente12" size="2" tabindex="50" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente12');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente12" id="cod_cliente12" size="5" tabindex="51" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente12');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos12"></span>
           <script language="javascript">addCampos('produto_cliente12');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente13" id="qtde_cliente13" size="2" tabindex="53" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente13');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente13" id="cod_cliente13" size="5" tabindex="54" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente13');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos13"></span>
           <script language="javascript">addCampos('produto_cliente13');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente14" id="qtde_cliente14" size="2" tabindex="56" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente14');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente14" id="cod_cliente14" size="5" tabindex="57" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente14');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos14"></span>
           <script language="javascript">addCampos('produto_cliente14');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente15" id="qtde_cliente15" size="2" tabindex="59" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente15');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente15" id="cod_cliente15" size="5" tabindex="60" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente15');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos15"></span>
           <script language="javascript">addCampos('produto_cliente15');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente16" id="qtde_cliente16" size="2" tabindex="62" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente16');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente16" id="cod_cliente16" size="5" tabindex="63" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente16');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos16"></span>
           <script language="javascript">addCampos('produto_cliente16');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente17" id="qtde_cliente17" size="2" tabindex="65" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente17');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente17" id="cod_cliente17" size="5" tabindex="66" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente17');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos17"></span>
           <script language="javascript">addCampos('produto_cliente17');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente18" id="qtde_cliente18" size="2" tabindex="68" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente18');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente18" id="cod_cliente18" size="5" tabindex="69" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente18');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos18"></span>
           <script language="javascript">addCampos('produto_cliente18');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente19" id="qtde_cliente19" size="2" tabindex="71" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente19');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente19" id="cod_cliente19" size="5" tabindex="72" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente19');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos19"></span>
           <script language="javascript">addCampos('produto_cliente19');</script>
           </td>
       </tr>
       <tr>
       	<td colspan="4">Qtde:&nbsp;&nbsp;<input name="qtde_cliente20" id="qtde_cliente20" size="2" tabindex="74" onkeyup="nu(this)" />
           <script language="javascript">addCampos('qtde_cliente20');</script>
           &nbsp;&nbsp;&nbsp;C&oacute;d.:&nbsp;&nbsp;<input name="cod_cliente20" id="cod_cliente20" size="5" tabindex="75" onkeyup="this.value = this.value.toUpperCase();" />
           <script language="javascript">addCampos('cod_cliente20');</script>&nbsp;&nbsp;&nbsp;Descri&ccedil;&atilde;o:&nbsp;&nbsp;<span id="produtos20"></span>
           <script language="javascript">addCampos('produto_cliente20');</script>
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
   </table>

	</form>

	</td>
 </tr>

</table>

<?php include_once "inc_rodape.php"; ?>

</body>

</html>