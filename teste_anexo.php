<?php

include_once( 'Email.class.php' );

$email = new Email( 'viollarr@gmail.com' );
$email->message( 'MINHA MENSAGEM DE TESTE' )
      ->addTo( 'viollarr@gmail.com' )
      ->subject( 'ASSUNTO' );

##################################################
 
// cria o objeto Attachment e adiciona os anexos
$attachments = new Attachment( 'teste.txt' );
//$attachments->addAttachment( 'outracoisa.html' )
  //          ->addAttachment( 'maisum.pdf' );

// adiciona o objeto Attachment no email
$email->addAttachment( $attachments );

##################################################

$email->send( ); // envia o email
?> 