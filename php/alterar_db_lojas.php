<?


if (isset($_POST['editar_lojas']))

{
include"config.php";
$id_lojas = $_POST['id_lojas'];

$nome_loja		= $_POST['nome_loja'];
$cod_loja		= $_POST['cod_loja'];
$gerente_loja	= $_POST['gerente_loja'];
$tel_loja		= $_POST['tel_loja'];
$tel2_loja		= $_POST['tel2_loja'];
$tel3_loja		= $_POST['tel3_loja'];
$tel4_loja		= $_POST['tel4_loja'];
$email_loja		= $_POST['email_loja'];

$query	= "
	UPDATE lojas SET 
	cod_loja 		= '".$cod_loja."',
	nome_loja 		= '".$nome_loja."', 
	gerente_loja 	= '".$gerente_loja."',
	tel_loja 		= '".$tel_loja."',
	tel2_loja 		= '".$tel2_loja."',
	tel3_loja 		= '".$tel3_loja."',
	tel4_loja 		= '".$tel4_loja."',
	email_loja 		= '".$email_loja."'
	WHERE id_loja	='".$id_lojas."'";

//echo $query;
//exit();
$result	= mysql_query($query);

Header("Location: ../adm_lojas.php");

}

?>