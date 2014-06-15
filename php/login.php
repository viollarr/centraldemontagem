<?php
include "config.php";

// obtém os valores digitados
$login		= $_POST["login"];
$senha		= $_POST["senha"];
$data_hora 	=  date("Y-m-d H:i:s");

// acesso ao banco de dados
$resultado	= mysql_query("SELECT * FROM usuarios WHERE login='$login'");
$linhas		= mysql_num_rows($resultado);
$a = mysql_fetch_array($resultado);
if ($linhas==0)  // testa se a consulta retornou algum registro
{
	echo("<script>
			alert(\"Usuário N&Atilde;O encontrado\");
			window.location = '../index.php';
         </script>");
}
else
{
    if ($senha != mysql_result($resultado, 0, "senha")) // confere senha
	{
		echo("<script>
				alert(\"A senha está incorreta\");
				window.location = '../index.php';
			  </script>");
	}
	else   // usuário e senha corretos. Vamos criar os cookies
    {
        //setcookie("nome_usuario", $username);
        //setcookie("senha_usuario", $senha);
		//---- Cria sessão, depois do login...
		session_start();
		#$_SESSION['login_adm']	= $login;		
		$_SESSION['login']			= $login;
		if(($_SERVER['REMOTE_ADDR'] == '187.76.192.124') || ($a['acesso_externo'] == 'sim')){
			$_SESSION['tipo']		= $a['tipo'];
			
			################################################################################################################
			include"../classe/Log_Aceito.class.php";
			
			$objLog = new Log();
			$objLog->grava(" ");
			$objLog->grava("ACESSO PERMITIDO NA RICARDO ELETRO");
			$objLog->grava('NOME => "'.$a['nome'].'", LOGIN => "'.$a['login'].'", DATA => "'.date('Y-m-d H:i:s').'", IP => "'.$_SERVER['REMOTE_ADDR'].'"');
			
			#################################################################################################################
		}
		else{
			$_SESSION['tipo']		= '4';
			
			################################################################################################################
			include"../classe/Log_Restrito.class.php";
					
			$objLog = new Log();
			$objLog->grava(" ");
			$objLog->grava("ACESSO FORA DA RICARDO ELETRO");
			$objLog->grava('NOME => "'.$a['nome'].'", LOGIN => "'.$a['login'].'", DATA => "'.date('Y-m-d H:i:s').'", IP => "'.$_SERVER['REMOTE_ADDR'].'"');
			
			#################################################################################################################
			
			echo("<script>window.location = '../acesso_negado.php';</script>");			
		}
		$_SESSION['id_usuario']		= $a['id'];
		$_SESSION['id_montador']	= $a['id_montador'];
		
		$up_ip = "UPDATE usuarios SET ip = '".$_SERVER['REMOTE_ADDR']."', data_hora = '".$data_hora."' WHERE id='".$a['id']."'";
		$query_up = mysql_query($up_ip);
		
        // direciona para a página inicial dos usuários cadastrados
		if ($a['tipo'] != 5){
        	echo("<script>window.location = '../adm_clientes.php';</script>");  
		}
		else{
        	echo("<script>window.location = '../adm_montador.php';</script>");  
		}
    }
}
//mysql_close($con);
?>