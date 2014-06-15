<?php
include_once "php/valida_sessao.php";
include"php/config.php";

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
	<link rel="stylesheet" href="css/estilo.css" type="text/css" />
    <link rel="stylesheet" href="js/datepiker/themes/base/jquery.ui.all.css" type="text/css" />
	<script type="text/javascript" src="js/jquery.js"></script>
    <script src="js/datepiker/ui/jquery.ui.core.js" type="text/javascript"></script>
    <script src="js/datepiker/ui/jquery.ui.datepicker.js" type="text/javascript"></script>
    <script src="js/datepiker/ui/i18n/jquery.ui.datepicker-pt-BR.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
	<script type="text/javascript" src="js/funcoes.js"></script>
 <script type="text/javascript">
   jQuery(document).ready(function($){
   
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
		$("#ctpsnumero").mask("?39/?19");
		$(".cep").mask("99999-999");
   });
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
        alert("'"+s+"' NãO é um CPF ou um CNPJ válido!" ); // tamanho inválido
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

</head>
<body>
<?php //include_once "inc_topo.php"; ?>
<table width="778" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td width="200px" align="center" valign="top" class="menu"><?php include_once "inc_menu.php"; ?></td>
    <td width="578" valign="top">
	<form action="php/inc_cad_montadores.php" method="post" id="teste"  name="frm_servico">
	<table width="570" border="0" align="center" cellpadding="2" cellspacing="1" class="texto cor_tr">
      <tr>
        <td colspan="4" align="center" bgcolor="#FFFFFF"><input type="image" src="img/ico_salvar.jpg" alt="Salvar" title="Salvar" name="salvar" /></td>
        <script language="javascript">addCampos('salvar');</script>
      </tr>
	  <tr>
		<td colspan="4" class="titulo">Cadastro de Montadores</td>
	  </tr>
    	 <tr>
         	<td align="left">Empresa:</td>
			<td colspan="3">
				<input type="radio" checked="checked" name="empresa" value="1" /><strong>RE(RJ)</strong>
				<script language="javascript">addCampos('empresa');</script>
			</td>
         </tr>
     <tr><td colspan="4">&nbsp;</td></tr>
    	 <tr>
			<td align="left" colspan="4"> Funcionário Responsável
				<select name="id_responsavel">
                	<option value='0'  selected='selected'>Escolha o Responsavel</option>
                	<?php
						$select_responsavel = "SELECT id, nome FROM usuarios WHERE tipo = '2' OR tipo = '3'  OR tipo = '1'";
						$query_responsavel = mysql_query($select_responsavel);
						
						while($resp = mysql_fetch_array($query_responsavel)){
						
					?>
                    		<option value="<?=$resp['id']?>"><?=$resp['nome']?></option>
                    <?php
						}
					?>
                </select>
				<script language="javascript">addCampos('id_responsavel');</script>
			</td>
         </tr>
    <tr>
        <td width="104" align="left">Nome Completo: </td>
        <td align="left"><input type="text" size="50" name="nome_comp" id="nome_comp" tabindex="1" onkeyup="this.value = this.value.toUpperCase();" /></td>
        <script language="javascript">addCampos('nome_comp');</script>
        <td align="left" colspan="2">
        	Rota:&nbsp;&nbsp;<input type="text" name="rota" id="rota" size="15" tabindex="2" onkeyup="this.value = this.value.toUpperCase();" />
        <script language="javascript">addCampos('rota');</script>
        </td> 
    </tr>
    <tr>
        <td align="left">Incluir Foto: </td>
        <td align="left" colspan="3"><input type="file" name="foto" tabindex="3" /></td>
        
              <script language="javascript">addCampos('foto');</script>
    </tr>
    <tr>
        <td align="left">Admiss&atilde;o: </td>
        <td width="354" align="left" colspan="3"><input type="text" name="admissao" class="data datepicker" id="admissao" maxlength="10" size="10"  tabindex="4" />
        <script language="javascript">addCampos('admissao');</script>
        
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        Demiss&atilde;o:&nbsp;&nbsp;&nbsp;&nbsp; <input type="text" name="demissao" class="data datepicker" id="demissao" size="10" maxlength="10" tabindex="5" /></td>
      <script language="javascript">addCampos('demissao');</script>
      
     </tr>
    <tr>
        <td align="left">Banco: </td>
        <td width="354" align="left" colspan="3"><input name="banco" type="text" id="banco" size="20"  tabindex="6" onkeyup="this.value = this.value.toUpperCase();" />
        <script language="javascript">addCampos('banco');</script>
        Nome Conta:&nbsp;&nbsp;<input type="text" name="nome_conta" id="nome_conta" size="30" tabindex="7" onkeyup="this.value = this.value.toUpperCase();"  />
        <script language="javascript">addCampos('nome_conta');</script>
        </td>
    </tr>
    <tr>
        <td align="left">Ag.:</td>
        <td align="left" colspan="3"><input type="text" name="agencia" id="agencia" size="15" tabindex="8" onkeyup="this.value = this.value.toUpperCase();"  />
        <script language="javascript">addCampos('agencia');</script>
        Conta:&nbsp;&nbsp;<input type="text" name="conta" id="conta" size="15" tabindex="9" onkeyup="this.value = this.value.toUpperCase();"  />
        <script language="javascript">addCampos('conta');</script></td>
     </tr>
		<tr>
        	<td align="left">CTPS Série</td>
        	<td align="left" colspan="1"><input type="text" name="ctpsserie" id="ctpsserie" size="5" tabindex="7" />
        	<script language="javascript">addCampos('ctpsserie');</script>
        	CTPS Número:&nbsp;&nbsp;<input type="text" name="ctpsnumero" id="ctpsnumero" size="15" tabindex="8" />
        	<script language="javascript">addCampos('ctpsnumero');</script></td>
            <td align="left" colspan="2">CTPS UF:&nbsp;&nbsp;<input type="text" name="ctpsuf" id="ctpsuf" size="4" maxlength="2" tabindex="8" onkeyup="this.value = this.value.toUpperCase();" />
        	<script language="javascript">addCampos('ctpsuf');</script></td>
     	</tr>        
    <tr>
        <td align="left">Data Nascimento: </td>
        <td width="354" align="left" colspan="3"><input name="dataNascimento" type="text" id="dataNascimento" class="data datepicker" maxlength="10" size="10"  tabindex="10" /></td>
        <script language="javascript">addCampos('dataNascimento');</script>
    </tr>
    <tr>
        <td align="left">RG: </td>
        <td width="354" align="left" colspan="3"><input name="rg" type="text" id="rg" maxlength="18" size="40"  tabindex="10" /></td>
        <script language="javascript">addCampos('rg');</script>
    </tr>
    <tr>
        <td align="left">CPF: </td>
        <td width="354" align="left"><input name="cpf" type="text" id="cpf" ondblclick="validar(this)" maxlength="18" size="40"  tabindex="11" /></td>
        <script language="javascript">addCampos('cpf');</script>
        <td width="56" align="left">CEP: </td>
      <td align="left"><input name="cep" id="cep"  class="cep" size="10" maxlength="8" onblur="getEndereco()" tabindex="12" /></td>
      <script language="javascript">addCampos('cep');</script>
    </tr>
     <tr>
       <td align="left">Endere&ccedil;o: </td>
       <td align="left" colspan="3"><input name="rua" id="rua" size="60"  tabindex="13" onkeydown="this.value = this.value.toUpperCase();"/></td>
       <script language="javascript">addCampos('rua');</script>
     </tr>
     <tr>
     	<td align="left">N&deg; :</td>

		<td align="left" colspan="3"><input type="text" name="numero" id="numero" size="5" tabindex="14" />
       <script language="javascript">addCampos('numero');</script>&nbsp;&nbsp;&nbsp;
       Comp.:	<input type="text" name="comp" id="comp" size="10" tabindex="15" onkeyup="this.value = this.value.toUpperCase();" /></td>
       <script language="javascript">addCampos('comp');</script>
 	  </tr>
     <tr>
       <td align="left">Estado*: </td>
       <td align="left" colspan="3">
     		<select name="estado" id="estado" tabindex="16">
                <option value=""></option>
                <?php
                    foreach($estados AS $estado){
                        echo '<option uf="'.$estado['sigla'].'" value="'.$estado['cod_estados'].'">'.$estado['sigla'].'</option>';
                    }
                ?>
            </select> <br />
       <script language="javascript">addCampos('estado');</script>
       </td>
     </tr>
     <tr>
     	<td align="left">Cidade</td>
        <td align="left" colspan="3">
        	<select name="cidade" id="cidade" class="select_model" tabindex="17">
            	<option value="">-- Escolha um estado --</option>
            </select>
       	</td>
       <script language="javascript">addCampos('cidade');</script>
     </tr>
     <tr>
       <td align="left">Bairro*: </td>
       <td align="left" colspan="3">
     		<select name="bairro" id="bairro" tabindex="18">
            	<option value="">-- Escolha um bairro --</option>
            </select> <br />
       <script language="javascript">addCampos('bairro');</script>
       </td>
     </tr>
    <tr>
        <td align="left">Telefone: </td>
        <td align="left"><input type="text" name="res" id="res" size="13" class="telefone" tabindex="20" /></td>
         <script language="javascript">addCampos('res');</script>
        <td align="left">Celular: </td>
        <td align="left"><input type="text" name="cel" id="cel" size="13" class="telefone" tabindex="21" /></td>
         <script language="javascript">addCampos('cel');</script>
    </tr>
    <tr>
        <td align="left">Email: </td>
        <td align="left" colspan="3"><input type="text" name="email" id="email" size="30" maxlength="50" tabindex="23" /></td>
        <script language="javascript">addCampos('email');</script>
    </tr>
    <tr>
        <td align="left" colspan="4">Coment&aacute;rio:<br /> 
        	<textarea name="observacao" id="observacao" cols="40" rows="10" tabindex="24"></textarea>
        <script language="javascript">addCampos('observacao');</script>
        
        </td>
  </tr>
    <tr>
        <td align="left" colspan="4">Selecione os Locais de Atendimento</td>
  	</tr>
    <tr>
        <td align="left" colspan="4">
        	<?php include "php/config.php"; ?>
            <select name="atendimento[]" multiple="multiple" size="4" tabindex="25">
            	<?php
				/*
					$select = "SELECT * FROM bairros ORDER BY nome ASC";
					$query = mysql_query($select);
					while($a = mysql_fetch_array($query)){
						echo '<option value="'.$a[id_bairros].'">'.htmlentities($a[nome]).'</option>';
					}
				*/
					$select = "SELECT DISTINCT(bairro) FROM RJ ORDER BY bairro ASC";
					$query = mysql_query($select);
					while($b = mysql_fetch_array($query)){
						echo '<option value="'.$b[bairro].'">'.strtoupper(strtr(strtoupper(utf8_encode(strtoupper($b['bairro']))) ,"áéíóúâêôãõàèìòùç","ÁÉÍÓÚÂÊÔÃÕÀÈÌÒÙÇ")).'</option>';
					}
				
				?>
            </select>
            <script language="javascript">addCampos('atendimento[]');</script>
            <br /><br />
            * Para selecionar mais de um <strong>BAIRRO</strong> favor segurar o bot&atilde;o "<strong>Ctrl</strong>" no teclado e <strong>clicar</strong> com o mouse no outro bairro.
        </td>
  	</tr>
    </table>
	</form>
	</td>
  </tr>
</table>
<?php include_once "inc_rodape.php"; ?>
</body>
</html>