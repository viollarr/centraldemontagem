<?php

include_once "php/valida_sessao.php";

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">



<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

	<title>CENTRAL DE MONTAGEM</title>

<script type="text/javascript" src="js/funcoes.js"></script>

    <script type="text/javascript" src="js/jquery.js"></script>

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

						alert("Endere�o Não encontrado");

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

    var tam=(s).length; // removendo os caracteres Não num�ricos

    if (!(tam==11 || tam==14)){ // validando o tamanho

        alert("'"+s+"' Não � um CPF ou um CNPJ válido!" ); // tamanho inválido

        return false;

    }

// se for CPF

    if (tam==11 ){

        if (!validaCPF(s)){ // chama a fun��o que valida o CPF

            alert("'"+s+"' Não � um CPF válido!" ); // se quiser mostrar o erro

            obj.select();  // se quiser selecionar o campo em quest�o

            return false;

        }

        obj.value=maskCPF(s);    // se validou o CPF mascaramos corretamente

        return true;

    }

// se for CNPJ

    if (tam==14){

        if(!validaCNPJ(s)){ // chama a fun��o que valida o CNPJ

            alert("'"+s+"' Não � um CNPJ válido!" ); // se quiser mostrar o erro

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



}

</script>

<script language="javascript" type="text/javascript">

function validaAssistencia() {

	if(document.assistencia.protocolo.value == "") {

		alert("Defina o PROTOCOLO");

		document.assistencia.protocolo.focus();		

        return false;		

	}

	if(document.assistencia.data_faturamento.value == "") {

		alert("Defina a data de FATURAMENTO");

		document.assistencia.data_faturamento.focus();		

        return false;		

	}

	if(document.assistencia.protocolo.value != "" && document.assistencia.data_faturamento.value != "") {

		alert("teste");

		document.assistencia.action="php/cadastrando_assis.php";

		document.assistencia.submit();

	};

};



</script>

	<link rel="stylesheet" href="css/estilo.css" type="text/css" />



</head>





<body>

<?php //include_once "inc_topo.php"; ?>

<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">

  <tr>

    <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu.php"; ?></td>

    <td width="578" valign="top">

	  <table width="570" border="0" align="center">

      <tr>

        <td><?php include "php/inc_cadastrar_assistencia.php"; ?></td>

      </tr>

      <tr>

        <td>&nbsp;</td>

      </tr>

    </table>

	</td>

  </tr>

</table>

<?php include_once "inc_rodape.php"; ?>

</body>

</html>