
<link rel="stylesheet" type="text/css" href="css/sddm.css" >
<br />
<div class="navbar"><!-- *********************************Start Menu****************************** -->
<?php	if($_SESSION['login'] == 'narcizo'){ /* if($_SESSION['tipo'] == '1'){*/?>
<div class="mainDiv" ><div class="topItem"  >Arquivo</div>
	<div class="dropMenu" ><!-- -->	
		<div class="subMenu" style="display:none;">
			<div class="subItem"><a href="admin_impressoes_vales.php">Emitir vales</a></div>
			</div>
		</div>
</div>
<!-- *********************************End Menu****************************** -->
<br>
<?php }?>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem"  >CLIENTES</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
		<div class="subItem"><a href="adm_clientes.php">Administrar Clientes</a></div>
     <?php
	 	if($_SESSION['tipo'] != 4){   
			echo'<div class="subItem"><a href="cad_clientes.php">Cadastrar Clientes</a></div>';
		}			  /*  if(($_SESSION['login'] == 'narcizo')){			echo '<div class="subItem"><a href="adm_clientes_validar.php">Validar Cadastro</a></div>';			echo '<div class="subItem"><a href="adm_arquivos.php">Cadastrar Arquivo Mont.</a></div>';		} */					
	    if($_SESSION['tipo'] == 1){
			echo '<div class="subItem"><a href="admim_atrasados_montadora.php">Atrasados Montadora</a></div>';
			echo '<div class="subItem"><a href="admim_atrasados_atendimento.php">Atrasados Atendimento</a></div>';
			echo '<div class="subItem"><a href="admim_atrasados_geral.php">Total de Atrasados</a></div>';
			echo '<div class="subItem"><a href="em_dia_montadora.php">Prazo Montadora</a></div>';
			echo '<div class="subItem"><a href="em_dia_atendimento.php">Prazo Atedimento</a></div>';
			echo '<div class="subItem"><a href="em_dia.php">Total no Prazo</a></div>';
			echo '<div class="subItem"><a href="adm_clientes_validar.php">Validar Cadastro</a></div>';
			echo '<div class="subItem"><a href="adm_arquivos.php">Cadastrar Arquivo Mont.</a></div>';
		}	
		 if(($_SESSION['tipo'] == 3)||($_SESSION['tipo'] == 2)){
				echo '<div class="subItem"><a href="adm_clientes_validar.php">Validar Cadastro</a></div>';
				echo '<div class="subItem"><a href="adm_arquivos.php">Cadastrar Arquivo Mont.</a></div>';
		 }
		 /*
		 if($_SESSION['login'] == 'narcizo'){
			echo '<div class="subItem"><a href="adm_clientes_validar.php">Validar Cadastro</a></div>';
			echo '<div class="subItem"><a href="adm_arquivos.php">Cadastrar Arquivo Mont.</a></div>';			 
		 }
		 */

	?>
	</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<?php 
if ($_SESSION['tipo'] != 4){
?>
<br>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem"  >ASSISTÊNCIA TEC.</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
        <div class="subItem"><a href="admim_assistencia.php">Emitir</a></div>
		</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<?php 
	}
if ($_SESSION['tipo'] != 4){
?>
<br>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem"  >MONTADORES</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
		<div class="subItem"><a href="adm_montadores.php">Administrar Montadores</a></div>
		<div class="subItem"><a href="cad_montadores.php">Cadastrar Montadores</a></div>
        <div class="subItem"><a href="admin_atrasados.php">Montadores c/ Atrasos</a></div>
		</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<br>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem" >PRODUTOS</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
		<div class="subItem"><a href="adm_produtos.php">Administrar Produtos</a></div>
		<div class="subItem"><a href="cad_produtos.php">Cadastrar Produtos</a></div>
        <?php
		if($_SESSION['tipo'] == 1){
			echo '<div class="subItem"><a href="cadastro_precos.php">Cadastrar Preços/produtos</a></div>';
		}
		?>
		</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<?php 
	}
?>
<br>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem" >LOJAS</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
		<div class="subItem"><a href="adm_lojas.php">Administrar Lojas</a></div>
		<div class="subItem"><a href="cad_lojas.php">Cadastrar Lojas</a></div>
		</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<br>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem">BAIRROS</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
		<div class="subItem"><a href="adm_bairros.php">Administrar Bairros</a></div>
		<div class="subItem"><a href="cad_bairros.php">Cadastrar Bairros</a></div>
		</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<br>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem"  >RELATÓRIOS</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
    	<?php
		if($_SESSION['tipo'] != 4){
			echo '<div class="subItem"><a href="admim_relatorios.php">Notas</a></div>';
        }
		echo '<div class="subItem"><a href="admim_relatorios_pre_baixa.php">Pré-Baixa</a></div>';

		if ($_SESSION['tipo'] == 1){
		?>
    	<!--<div class="subItem"><a href="admim_relatorios_rendimentos.php">Rendimentos</a></div>-->
        <div class="subItem"><a href="admim_relatorios_graficos_pre_baixa.php">Gráfico Pré-Baixa</a></div>
        <div class="subItem"><a href="admim_relatorios_graficos_montadora.php">Gráfico Montadora</a></div>
        <div class="subItem"><a href="admim_relatorios_graficos_montadores.php">Gráfico Montadores</a></div>        
        <?php
		}
		elseif($_SESSION['tipo'] == 4){
			echo '<div class="subItem"><a href="admim_relatorios_graficos_montadora.php">Gráfico Montadora</a></div>';
		}
		?>
	</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<?php 
if ($_SESSION['tipo'] != 4){
?>
<br>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem"  >AGENDAMENTO</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
		<div class="subItem"><a href="adm_notas.php">Alterar Nota</a></div>
		<!-- <div class="subItem"><a href="adm_valida_notas.php">Validar Nota</a></div>-->
	</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<?php 
}
if (($_SESSION['tipo'] == 1) || ($_SESSION['tipo'] == 2) || ($_SESSION['tipo'] == 3)){
?>
<br>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem"  >BAIXA DE NOTAS</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
    	<div class="subItem"><a href="admim_pre_baixas.php">Executar Pré-Baixa</a></div>
		<div class="subItem"><a href="admim_baixas.php">Avaliar Nota</a></div>
	</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<?php 
}
if (($_SESSION['tipo'] == 1) || ($_SESSION['tipo'] == 3) || ($_SESSION['tipo'] == 2)){
?>

<br>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem"  >PAGAMENTOS</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
		<div class="subItem"><a href="admim_relatorios_montadores.php">Pg Montadores (Indiv.)</a></div>
        <div class="subItem"><a href="admim_relatorios_montadores_geral.php">Pg Montadores (Todos)</a></div>
        <!--<div class="subItem"><a href="admim_relatorios_montadores_re.php">Pg Montadores CP</a></div>-->
        <?php
		if (($_SESSION['tipo'] == 1)){
		?>
    	<!--<div class="subItem"><a href="admim_relatorios_presty.php">Solicitar Pagamentos</a></div>-->
        <?php
		}
		?>
	</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<?php 
}
?>
<!--
<br>
<!-- *********************************Start Menu****************************** -->
<!--
<div class="mainDiv" >
<div class="topItem">CHAT</div>        
<div class="dropMenu" ><!-- 
	<div class="subMenu" style="display:none;">
		<div class="subItem"><a href="#">Acessar Chat</a></div>
		</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->
<br>
<!-- *********************************Start Menu****************************** -->
<div class="mainDiv" >
<div class="topItem"  >SISTEMA</div>        
<div class="dropMenu" ><!-- -->
	<div class="subMenu" style="display:none;">
<?php
if ($_SESSION['tipo'] == 1){
?>
		<div class="subItem"><a href="adm_usuarios.php">Usuários</a></div>
<?php
}
?>
		<div class="subItem"><a href="php/sair.php">Sair</a></div>
	</div>
</div>
</div>
<!-- *********************************End Menu****************************** -->

<script type="text/javascript" src="js/xpmenuv21.js"></script>
</div>
<br />