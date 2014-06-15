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
	   <script type="text/javascript" src="js/funcoes.js"></script>
	<script type="text/javascript">
      jQuery(document).ready(function($){
            $("#admissao").datepicker({
                onSelect: function( selectedDate ) {
                    $("#demissao").datepicker( "option", "minDate", selectedDate );
                }
            });
            $("#demissao").datepicker({
                onSelect: function( selectedDate ) {
                    $("#admissao").datepicker( "option", "maxDate", selectedDate );
                }
            });
      });
      
      //função que inicia o datepicker
      jQuery(function($) {
            $(".datepicker").datepicker( $.datepicker.regional[ "pt-BR" ] );
            $(".telefone").mask("(99)9999-9999");
            $(".data").mask("99/99/9999");
			$(".cep").mask("99999-999");
      });
    </script>
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
	if(j.length>0){
		for (var i = 0; i < j.length; i++) {
			option[i] = document.createElement('option');//criando o option
						$( option[i] ).attr( {value : j[i].bairro, selected : ( bairro == j[i].bairro ) ? true : false } );//colocando o value no option
						$( option[i] ).append( j[i].bairro.toUpperCase() );//colocando o 'label'
						
		}
	}
	else{
		option[i] = document.createElement('option');//criando o option
		$( option[i] ).attr( {value : ''} );//colocando o value no option
		$( option[i] ).append("-- Não tem bairros para esta cidade --");//colocando o 'label'
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
   var tam=(s).length; // removendo os caracteres Não numéricos
   if (!(tam==11 || tam==14)){ // validando o tamanho
       alert("'"+s+"' Não é um CPF ou um CNPJ válido!" ); // tamanho inválido
       return false;
   }

// se for CPF
   if (tam==11 ){
       if (!validaCPF(s)){ // chama a função que valida o CPF
           alert("'"+s+"' Não é um CPF válido!" ); // se quiser mostrar o erro
           obj.select();  // se quiser selecionar o campo em quest�o
           return false;
       }
       obj.value=maskCPF(s);    // se validou o CPF mascaramos corretamente
       return true;
   }

// se for CNPJ
   if (tam==14){
       if(!validaCNPJ(s)){ // chama a função que valida o CNPJ
           alert("'"+s+"' Não é um CNPJ válido!" ); // se quiser mostrar o erro
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
				resetaCombo("bairro");
				buscaBairros($("#estado option:selected").attr("uf"),$("#cidade option:selected").attr("cid"),'');
			}
		});

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
       <td><?php include "php/inc_vis_montadores.php"; ?></td>
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