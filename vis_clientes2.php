<?php
include_once "php/valida_sessao.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>CENTRAL DE MONTAGEM</title>
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
		   $(".cep").mask("99999-999");
     });
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
<script type="text/javascript">

function getEndereco() {
		if(($.trim($("#cep").val()) != "")||($.trim($("#cep").val()) != "_____-___")){
			$.getScript("http://cep.republicavirtual.com.br/web_cep.php?formato=javascript&cep="+$("#cep").val(), function(){
				if(resultadoCEP["resultado"]>0){
					buscaEndereco($("#cep").val(), resultadoCEP["uf"].toUpperCase());
				}
			});				
		}
	}

function buscaEndereco(cep, uf) {
	$.getJSON('php/busca_endereco.php',{cep: cep, uf: uf, ajax: 'true'}, function(j){
		//alert("teste");
		$("#rua").val(unescape(j.tp_logradouro).toUpperCase()+" "+unescape(j.logradouro).toUpperCase());
		if($("select[name='estado']").has('option[uf='+unescape(uf)+']').size()>0){
			$("select[name='estado'] option[uf="+unescape(uf)+"]").attr('selected',true).parent().trigger('change',[removeAcentos(unescape(j.cidade))]);
		}
		
		buscaBairros(uf, j.cidade, j.bairro);
		
	});
}

function buscaBairros(uf, cidade, bairro) {
	$.getJSON('php/busca_bairros.php',{uf: uf, cidade: cidade, ajax: 'true'}, function(j){
	var option = new Array();
	for (var i = 0; i < j.length; i++) {
		option[i] = document.createElement('option');//criando o option
					$( option[i] ).attr( {value : j[i].bairro, selected : ( bairro == j[i].bairro ) ? true : false } );//colocando o value no option
					$( option[i] ).append( j[i].bairro.toUpperCase() );//colocando o 'label'
					
	}	
	$('#bairro').html(option).show();
	});	
}

function removeAcentos(texto) {
	var chrEspeciais = new Array("á", "à", "â", "ã", "ä", "é", "è", "ê", "ë",
				     "í", "ì", "î", "ï", "ó", "ò", "ô", "õ", "ö",
				     "ú", "ù", "û", "ü", "ç",
				     "Á", "À", "Â", "Ã", "Ä", "É", "È", "Ê", "Ë",
				     "Í", "Ì", "Î", "Ï", "Ó", "Ò", "Ô", "Õ", "Ö",
				     "Ú", "Ù", "Û", "Ü", "Ç");
	var chrNormais = new Array("a", "a", "a", "a", "a", "e", "e", "e", "e",
				   "i", "i", "i", "i", "o", "o", "o", "o", "o",
				   "u", "u", "u", "u", "c",
				   "A", "A", "A", "A", "A", "E", "E", "E", "E",
				   "I", "I", "I", "I", "O", "O", "O", "O", "O",
				   "U", "U", "U", "U", "C");
	for (index in chrEspeciais) {
		texto = texto.replace(chrEspeciais[index], chrNormais[index]);
	}
	
	return texto;
}
	/* função pronta para ser reaproveitada, caso queira adicionar mais combos dependentes */
	function resetaCombo( el )
	{
		$("select[name='"+el+"'] option").remove();//retira os elementos antigos
		var option = document.createElement('option');                                  
		$( option ).attr( {value : '0'} );
		$( option ).append( '-- Escolha uma Cidade --' );
		$("select[name='"+el+"']").append( option );
		$('.loader').hide();
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



function printDiv(id, pg) {

	var oPrint, oJan;

	oPrint = window.document.getElementById(id).innerHTML;

	oJan = window.open(pg);

	oJan.document.write(oPrint);

	oJan.window.print();
      oJan.document.close();
      oJan.focus();

}

</script>

<script language="javascript" type="text/javascript">

	$(document).ready(function(){
		
		$("select[name='estado']").bind("change",function(e, cidade){
	        var IdSelEstado = parseInt($(this).val());//pegando o value do option selecionado
			var IdSelCidade = cidade||'';
	        //alert(IdSelEstado);//apenas para debugar a variável
	        
			$('#cidade').next('.loader').show();
			
	        if ( IdSelEstado < 1 ) {
	        	resetaCombo('cidade');
	        	return;
	        }
				$.getJSON(//esse método do jQuery, só envia GET
						'php/cidades.php?search=',//script server-side que deverá retornar um objeto jSON
						{cod_estados: IdSelEstado},//enviando a variável
	
						function(data){
						//alert(data);//apenas para debugar a variável
								
								var option = new Array();//resetando a variável
								
								resetaCombo('cidade');//resetando o combo
								resetaCombo('bairro');//resetando o combo
								$.each(data, function(i, obj){
										
										option[i] = document.createElement('option');//criando o option
										$( option[i] ).attr( {value : obj.cod_cidades, cid : obj.nome, selected : ( IdSelCidade == removeAcentos(obj.nome) ) ? true : false } );//colocando o value no option
										$( option[i] ).append( obj.nome.toUpperCase() );//colocando o 'label'
	
										$("select[name='cidade']").append( option[i] ).trigger('change');//jogando um à um os options no próximo combo
						});
				});
        });
		
		$("#cidade").bind("click",function(){
			if($(this).val() != 0){
				buscaBairros($("#estado option:selected").attr("uf"),$("#cidade option:selected").attr("cid"),'');
			}
		});

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
       <td><?php include "php/inc_vis_clientes2.php"; ?></td>
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