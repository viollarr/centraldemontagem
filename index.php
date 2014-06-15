<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
    <title>CENTRAL DE MONTAGEM</title>
    <link href="css/bootstrap.css" rel="stylesheet">
    <link href="css/bootstrap-responsive.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="css/estilo.css" />
    <link rel="stylesheet" type="text/css" href="css/sddm.css" >
    
    <script type="text/javascript" src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script> 
    
    <script type="text/javascript">
        jQuery(document).ready(function($){ 
            // Colocar o focus no input do login.
            $('#login').focus();
            //$(".esqueci_minha_senha").colorbox({iframe:true, width:"540px", height:"320px"});
        }); 
    </script>

<!--[if lt IE 9]>
<script>
document.createElement('header');
document.createElement('nav');
document.createElement('section');
document.createElement('article');
document.createElement('aside');
document.createElement('footer');
document.createElement('hgroup');
</script>
<![endif]-->
<!-- Pulled from http://code.google.com/p/html5shiv/ -->
<!--[if lt IE 9]>
<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->

</head>

<body>
    <div class="box_login">
<!--        <form class="form-horizontal">
          <div class="titulo_login">
            <label class="titulo_login">ACESSO RESTRITO</label>
          </div>
          <div class="control-group">
            <label class="control-label" for="inputEmail">Nome de usuário</label>
            <div class="controls">
              <input type="text" id="login" class="required" name="login" placeholder="informe seu usuário">
            </div>
          </div>
          <div class="control-group cor_tr">
            <label class="control-label" for="inputPassword">Senha</label>
            <div class="controls">
              <input type="password" id="inputPassword" name="senha" placeholder="informe sua senha">
            </div>
          </div>
          <div class="control-group">
            <div class="controls">
              <input type="submit" value="Enviar" name="enviar" />
            </div>
          </div>
          <div>
          	<a href="lembrar_senha.php">[ Esqueci a senha ]</a>
          </div>
        </form>    
-->        <table border="0" align="center" cellpadding="0" cellspacing="0" class="tbl_fundo_branco">
          <tr>
            <td valign="top">
            <form method="POST" action="php/login.php" name="frm">
            <table width="400" border="0" align="center" cellpadding="5" cellspacing="2" class="texto cor_tr">
             <tr>
                <td align="center" class="titulo" colspan="2">ACESSO RESTRITO</td>
              </tr>
              <tr>
                <td align="right" width="150">Nome de usuário: </td>
                <td align="left"><input name="login" type="text" id="login" class="required" /></td>
              </tr>
              <tr>
                <td align="right">Senha:</td>
                <td><input type="password" name="senha" class="required" /></td>
              </tr>
              <tr>
                <td align="center" colspan="2"><input type="submit" value="Enviar" name="enviar" /></td>
              </tr>
              <tr>
                <td align="center" colspan="2"><a href="lembrar_senha.php">[ Esqueci a senha ]</a></td>
              </tr>
            </table>
            </form></td>
          </tr>
        </table>
    </div>
</body>
</html>