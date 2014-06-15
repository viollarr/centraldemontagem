<?php
include_once "php/valida_sessao.php";
include ("php/config.php");
	$select_estados = "SELECT * FROM estados ORDER BY nome ASC";
	$query_estados = mysql_query($select_estados);
	while($x = mysql_fetch_assoc($query_estados)){
		$estados[] = $x;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>CENTRAL DE MONTAGEM</title>
    <link rel="stylesheet" href="js/datepiker/themes/base/jquery.ui.all.css" type="text/css" />
	<link rel="stylesheet" href="css/estilo.css" type="text/css" />
    <style>
		.filtros{
			display:none;	
		}
	</style>
	<script type="text/javascript" src="js/jquery.js"></script>
    <script src="js/datepiker/ui/jquery.ui.core.js" type="text/javascript"></script>
    <script src="js/datepiker/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
    <script src="js/datepiker/ui/i18n/jquery.ui.datepicker-pt-BR.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
 <script type="text/javascript">
   jQuery(document).ready(function($){
		$("#data_inicio").datepicker({
			changeMonth: true,
			onSelect: function( selectedDate ) {
				$("#data_final").datepicker( "option", "minDate", selectedDate );
			}
		});
		$("#data_final").datepicker({
			changeMonth: true,
			onSelect: function( selectedDate ) {
				$("#data_inicio").datepicker( "option", "maxDate", selectedDate );
			}
		});
		
		$('a#filtro').toggle(function() {
				$('a#filtro').html('- Filtros');
				$('.filtros').fadeIn();
				return false;
			  },
			function() {
				$('a#filtro').html('+ Filtros');
				$('.filtros').fadeOut();
				$('#estado option[value=""]').attr('selected','selected');
				resetaCombo('cidade');
				resetaCombo('bairro');
				return false;
			  });		
  
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
									resetaCombo('bairro');
									$.each(data, function(i, obj){
											
											option[i] = document.createElement('option');//criando o option
											$( option[i] ).attr( {value : obj.cod_cidades, cid : obj.nome, selected : ( IdSelCidade == removeAcentos(obj.nome) ) ? true : false } );//colocando o value no option
											$( option[i] ).append( obj.nome.toUpperCase() );//colocando o 'label'
		
											$("select[name='cidade']").append( option[i] );//jogando um à um os options no próximo combo
							});
					});
			});
			
			$("#cidade").bind("change",function(){
				if($(this).val() != 0){
					buscaBairros($("#estado option:selected").attr("uf"),$("#cidade option:selected").attr("cid"),'');
				}
			});
			
		});
		// FIM ON READY
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
				option[i] = document.createElement('option');//criando o option
				if(i==0){
					$( option[i] ).attr( {value : "", selected : true} );//colocando o value no option
				}
				else{
					$( option[i] ).attr( {value : j[i].bairro.toUpperCase(), selected : ( bairro.toUpperCase() == j[i].bairro.toUpperCase() ) ? true : false } );//colocando o value no option
				}
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
				$( option ).attr( {value : ''} );
				$( option ).append( '-- Escolha uma Cidade --' );
				$("select[name='"+el+"']").append( option );
				$('.loader').hide();
			}
   
   //função que inicia o datepicker
   jQuery(function($) {
		$(".datepicker").datepicker( $.datepicker.regional[ "pt-BR" ] );
		$(".data").mask("99/99/9999");
   });
 </script>
</head>
<body>
<?php //include_once "inc_topo.php"; ?>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200px" align="center" valign="top" class="menu"><? include_once "inc_menu.php"; ?></td>
    <td width="578" valign="top">
	<form action="adm_relatorios_pre_baixa.php" method="post" enctype="multipart/form-data" name="frm" id="frm">
	<table width="570" border="0" align="center">
	  <tr>
		<td class="titulo">Escolha o Tipo de Relat&oacute;rio Pré-Baixa</td>
	  </tr>
      <tr><td>&nbsp;</td></tr>
      <tr>
        <td><ul><li>Selecione um dos tipos de relat&oacute;rio para as notas de Pré-Baixas:</li></ul></td>
      </tr>
      <tr>
      	<td align="center" colspan="2">
            <table>
              <tr>
          		<td>Tipo Nota:</td>
                <td align="left" bgcolor="#FFFFFF">
                <select name="relat">
                    <option value="" selected="selected">---Escolha um Tipo---</option>
                    <option value="3">Montadas</option>
                    <option value="4">N&atilde;o Montadas</option>
                    <option value="1">Montado c/ Assist&ecirc;ncias</option>  
                    <option value="8">Tecnica Executada</option>
                    <option value="12">Tecnica N&atilde;o Executada</option>
                    <option value="9">Desmontagem Executada</option>
                    <option value="13">Desmontagem N&atilde;o Executada</option>
                    <option value="7">Revis&atilde;o Executada</option>
                    <option value="11">Revis&atilde;o N&atilde;o Executada</option>
                    <option value="6">Ausente</option>
                    <option value="5">Justi&ccedil;a Executada</option>
                    <option value="10">Justi&ccedil;a N&atilde;o Executada</option>
                    <option value="25">Pré-Baixa não realizada</option>
                </select>
            </td>
          </tr>
          <tr>
            <td>Data inicio:</td>
            <td align="left" bgcolor="#FFFFFF">
                <input type="text" name="data_inicio" id="data_inicio" class="data datepiker" size="10" />
            </td>
          </tr>
          <tr>
            <td>Data final:</td>
            <td align="left" bgcolor="#FFFFFF">
            <input type="text" name="data_final" id="data_final" class="data datepiker" size="10" />
           </td>
          </tr>
          <tr>
            <td colspan="2" align="right"><a href="#" id="filtro">+ Filtros</a></td>
          </tr>
            <tr class="filtros">
                <td>Estado:</td>
                <td align="left" bgcolor="#FFFFFF">
                    <select name="estado" id="estado" tabindex="13">
                        <option value=""></option>
                        <?php
                            foreach($estados AS $estado){
                                echo '<option uf="'.$estado['sigla'].'" value="'.$estado['cod_estados'].'">'.$estado['sigla'].'</option>';
                            }
                        ?>
                    </select> (opcional)
                </td>
            </tr>
            <tr class="filtros">
                <td>Cidade:</td>
                <td align="left" bgcolor="#FFFFFF">
                    <select name="cidade" id="cidade" class="select_model" tabindex="14">
                        <option value="">-- Escolha um estado --</option>
                    </select> (opcional)
                </td>
            </tr>
            <tr class="filtros">
                <td>Bairro:</td>
                <td align="left" bgcolor="#FFFFFF">
                    <select name="bairro" id="bairro" tabindex="15">
                        <option value="">-- Escolha um bairro --</option>
                    </select> (opcional)
                </td>
            </tr>
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr><td align="center" colspan="2"><input name="OK" type="submit"  value="OK"/></td></tr>
          </table>
        </td>
      <tr>
        <td>&nbsp;</td>
      </tr>
    </table>
	</form>
	</td>
  </tr>
</table>
<? include_once "inc_rodape.php"; ?>
</body>
</html>