<?php

include ("config.php");



############# ISCRICOES DISTINTAS ################

$select_insc2 = "SELECT DISTINCT (nome) FROM bairros ORDER BY nome ASC";

$sql_insc2 = mysql_query($select_insc2);

$rows_insc2 = mysql_num_rows($sql_insc2);

##################################################

############# ISCRICOES DISTINTAS ################

$select_insc = "SELECT * FROM montadores ORDER BY nome ASC";

$sql_insc = mysql_query($select_insc);

$rows_insc = mysql_num_rows($sql_insc);

##################################################

############# USUARIOS ###########################

?>



<table width="550" border="0" cellpadding="1" cellspacing="1" class="cor_tr">

  <form action="proc_adm_rela_notas.php" method="post" name="form">

    <tr>

        <td class='titulo' colspan="4">:: Gerar Relatórios de Notas ::</td>

    </tr>

    <tr><td class="texto" align="center" colspan="2"><p><strong>Escolha os Filtros:</strong></p></td></tr>

    <tr>

        <td class='texto' width='347'><b>Notas</b></td>

  		<td width="196" class='texto'>

	    <select name="nota" size="1" class="texto">

            <option value="3">MONTADAS</option>

            <option value="4">N&Atilde;O MONTADAS</option>

            <option value="1">ASSIST&Ecirc;NCIAS</option>

            <option value="2">NA EMPRESA</option>            

            <option value="6">AUSENTES</option>

            <option value="5">JUSTI&Ccedil;A</option>

        </select>

	  	</td>

  	</tr>

    <tr>

        <td class='texto' width='347'><b>Bairros de Atendimento</b></td>

  <td width="196" class='texto'>

  <select name="bairro" size="1" class="texto">

            	<option value="">---Escolha uma Bairro---</option>

                <option value="todos">TODOS OS BAIRROS</option>

			<?php

				for ($i=0;$i<$rows_insc2;$i++){

				

        			$insc = mysql_fetch_array($sql_insc2);

					echo '<option value="'.$insc['nome'].'">'.$insc['nome'].'</option>';

				}

			?>

            </select>

            

	  	</td>

  	</tr>

    <tr>

        <td class='texto' width='347'><b>Montadores</b></td>

  <td width="196" class='texto'>

  <select name="montadores" size="1" class="texto">

            	<option value="">---Escolha uma Bairro---</option>

                <option value="todos">TODOS OS MONTADORES</option>

			<?php

				for ($i=0;$i<$rows_insc;$i++){

				

        			$insc = mysql_fetch_array($sql_insc);

					echo '<option value="'.$insc['nome'].'">'.$insc['nome'].'</option>';

				}

			?>

            </select>

            

	  	</td>

  	</tr>

    <tr>

        <td class='texto' width='347'><b>Data Avaliação Inicial</b></td>

  		<td width="196" class='texto'>

  			<select name="dia_nota_inicial" size="1" class="texto">

            	<option value="">Dia</option>

				<option value="01">01</option>

                <option value="02">02</option>

                <option value="03">03</option>

                <option value="04">04</option>

                <option value="05">05</option>

                <option value="06">06</option>

                <option value="07">07</option>

                <option value="08">08</option>

                <option value="09">09</option>

                <option value="10">10</option>

			<?php

				for ($i=11;$i<32;$i++){

					echo '<option value="'.$i.'">'.$i.'</option>';

				}

			?>

            </select>

              <select name="mes_nota_inicial" size="1" class="texto">

            	<option value="">Mês</option>

				<option value="01">JAN</option>

                <option value="02">FEV</option>

                <option value="03">MAR</option>

                <option value="04">ABR</option>

                <option value="05">MAI</option>

                <option value="06">JUN</option>

                <option value="07">JUL</option>

                <option value="08">AGO</option>

                <option value="09">SET</option>

                <option value="10">OUT</option>

                <option value="11">NOV</option>

                <option value="12">DEZ</option>

	         </select>

    

            <select name="ano_nota_inicial" size="1" class="texto">

            	<option value="">Ano</option>

			<?php

				for ($i=2009;$i<(date(Y)+1);$i++){

					echo '<option value="'.$i.'">'.$i.'</option>';

				}

			?>

            </select>





	  	</td>

  	</tr>

    <tr>

        <td class='texto' width='347'><b>Data Avaliação Final</b></td>

  		<td width="196" class='texto'>

  			<select name="dia_nota_final" size="1" class="texto">

            	<option value="">Dia</option>

				<option value="01">01</option>

                <option value="02">02</option>

                <option value="03">03</option>

                <option value="04">04</option>

                <option value="05">05</option>

                <option value="06">06</option>

                <option value="07">07</option>

                <option value="08">08</option>

                <option value="09">09</option>

                <option value="10">10</option>

			<?php

				for ($i=11;$i<32;$i++){

					echo '<option value="'.$i.'">'.$i.'</option>';

				}

			?>

            </select>

              <select name="mes_nota_final" size="1" class="texto">

            	<option value="">Mês</option>

				<option value="01">JAN</option>

                <option value="02">FEV</option>

                <option value="03">MAR</option>

                <option value="04">ABR</option>

                <option value="05">MAI</option>

                <option value="06">JUN</option>

                <option value="07">JUL</option>

                <option value="08">AGO</option>

                <option value="09">SET</option>

                <option value="10">OUT</option>

                <option value="11">NOV</option>

                <option value="12">DEZ</option>

	         </select>

    

            <select name="ano_nota_final" size="1" class="texto">

            	<option value="">Ano</option>

			<?php

				for ($i=2006;$i<(date(Y)+1);$i++){

					echo '<option value="'.$i.'">'.$i.'</option>';

				}

			?>

            </select>





	  	</td>

  	</tr>

    <tr>

    	<td class="texto" align="center" colspan="2"><p><strong>Selecione o(s) campo(s) vão existir no relatório:</strong></p></td>

    </tr>

	<tr>

    	<td width='347' class='texto'  colspan="4">



		<table border='0' width='350'>

		  <tr>

        	<td width='347' class='texto'>Vale Montagem</td>

	  	 	<td class='texto'><input type='checkbox' name='n_montagem' value='n_montagem' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'>Or&ccedil;amento</td>

	   	    <td class='texto'><input type='checkbox' name='orcamento' value='orcamento' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'>Data Faturamento</td>

	   	    <td class='texto'><input type='checkbox' name='data_faturamento' value='data_faturamento' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'>Data Limite</td>

	   	    <td class='texto'><input type='checkbox' name='data_cadastro' value='data_cadastro' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'>Data Saída Montador</td>

	   	    <td class='texto'><input type='checkbox' name='data_saida_montador' value='data_saida_montador' /></td>

	      </tr>          

	      <tr>

	        <td class='texto' width='347'>Data Entrega Montador</td>

	   	    <td class='texto'><input type='checkbox' name='data_entrega_montador' value='data_entrega_montador' /></td>

	      </tr>          

	      <tr>

	        <td class='texto' width='347'>Data da Baixa</td>

	   	    <td class='texto'><input type='checkbox' name='data_final' value='data_final' /></td>

	      </tr>          

	      <tr>

	        <td class='texto' width='347'>Nome Cliente</td>

	   	    <td class='texto'><input type='checkbox' name='nome_cliente' value='nome_cliente' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'>Endere&ccedil;o</td>

	   	    <td class='texto'><input type='checkbox' name='endereco_cliente' value='endereco_cliente' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'>Bairro</td>

	   	    <td class='texto'><input type='checkbox' name='bairro_cliente' value='bairro_cliente' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'>Cidade</td>

	   	    <td class='texto'><input type='checkbox' name='cidade_cliente' value='cidade_cliente' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'>Telefone 1</td>

	   	    <td class='texto'><input type='checkbox' name='telefone1_cliente' value='telefone1_cliente' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'>Qtde. Produto</td>

	   	    <td class='texto'><input type='checkbox' name='qtde_cliente' value='qtde_cliente' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'>C&oacute;d. Produto</td>

	   	    <td class='texto'><input type='checkbox' name='cod_cliente' value='cod_cliente' /></td>

	      </tr>

          

	      <tr>

	        <td class='texto' width='347'>Nome Montador</td>

	   	    <td class='texto'><input type='checkbox' name='nome' value='nome' /></td>

	      </tr>

	      <tr>

	        <td class='texto' width='347'> Given Name </td>

	   	    <td class='texto'><input type='checkbox' name='givenname2' value='givenname' /></td>

	      </tr>

		  <tr>

			<td width='347' class='texto'><strong>Selecionar todos:</strong></td>

			<td class='texto'><input name='todas' type='checkbox' id='todas' value='checkbox' onClick='selecionar_todas(this.checked)'></td>

		  </tr>

   		  <tr><td class='texto' align='center' colspan='2'>&nbsp;</td></tr>

	      <tr>

      		  <td width='347' class='texto'><strong>Ordenado por:</strong></td>

			  <td class='texto'>

      			<select name='ordem' size='1' class='texto'>

            		<option value=''>---Escolha---</option>

	                <option value='nome_cliente'>Nome Cliente</option>

	                <option value='n_montagem'>Vale Montagem</option>

        	        <option value='orcamento'>Or&ccedil;amento</option>

            	    <option value='familyname'>Family Name</option>

                	<option value='givenname'>Given Name</option>



	                <option value='nametothebagde'>Name to the Bagde</option>

    	            <option value='affiliation'>Affiliation</option>

        	        <option value='mailingadress'>Mailing Adress</option>

            	    <option value='city'>City</option>

                	<option value='provincestate'>Province State</option>					



	                <option value='country '>Country</option>

    	            <option value='zipcode'>Zip Code</option>

        	        <option value='email'>Email</option>

            	    <option value='phone'>Phone</option>

                	<option value='fax'>Fax</option>

					

	                <option value='accompanyingperson'>Accompanying Person</option>

    	            <option value='letter'>Letter</option>

	   	            <option value='' disabled='disabled'>Packages:</option>

        	        <option value='profissional'>Profissional</option>

            	    <option value='student'>Student</option>

                	<option value='accompanyingperson2'>Accompanying Person</option>

					

	   	            <option value='' disabled='disabled'>Payment Methods:</option>

	                <option value='formpagamento'>Payment Methods</option>

    	            <option value='cartao'>Card</option>

        	        <option value='namecredit'>Name Card</option>

            	    <option value='datacartao'>Date of the Registration</option>

                	<option value='numcredit'>Number Card</option>

					

	                <option value='expiracartao'>Expiration Date</option>

    	            <option value='securitycode'>Security Code</option>

        	        <option value='totalescolhido'>Total</option>

	            </select>

    	    </td>

	      </tr>

		</table>

        </td>

    </tr>

    <tr><td class="texto" align="center" colspan="2">&nbsp;</td></tr>

    <tr>

    	<td align="center" colspan="2"><input type="submit" value="Gerar Relatório" /></td>

    </tr>

  </form>  

  <script type="text/javascript">

	formulario=document.form;

	function selecionar_todas(retorno){

	  if(retorno==true){

		  for(i=0;i<formulario.length;i++){

			if(formulario.elements[i].type=="checkbox" && formulario.elements[i].name!="todas"){

			  if(formulario.elements[i].checked==false){

				   formulario.elements[i].checked=true;

			  }

			}

		  }

	  } else {

		for(i=0;i<formulario.length;i++){

			if(formulario.elements[i].type=="checkbox" && formulario.elements[i].name!="todas"){

			  if(formulario.elements[i].checked==true){

				   formulario.elements[i].checked=false;

			  }

			}

		}

	  }

	}

  </script>

</table>

