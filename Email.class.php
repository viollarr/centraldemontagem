<?php 
/**
 *  Inclui a classe Attachment
 */
include_once( 'Attachment.class.php' );
/**
 *  Classe para enviar emails simples
 *  ou com multiplos anexos
 *  Created on 2011-07-15
 *  PHP version 5.3.0 and later
 *  @author Carlos Coelho <coelhoduda@hotmail.com>
 *  @version 0.2
 */
final class Email
{
    /**
     *  @var array Armazena todos os parâmetros de configuração
     *  para o envio do email
     *  @access private
     */
    private $storage = array
    (
        'priority' => 3,
        'charset'  => 'utf-8',
        'type'     => 'text/html',
    );
    /**
     *  O construtor da classe Email
     *  @param string $from O email do remetente
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function __construct( $from )
    {
        $this->storage[ 'from' ] = $from;
        return $this;
    }
    /**
     *  Define o assunto do email
     *  @param string $subject O assunto
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function subject( $subject )
    {
        $this->storage[ 'subject' ] = $subject;
        return $this;
    }
    /**
     *  Define a mensagem do email
     *  @param string $message A mensagem
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function message( $message )
    {
        $this->storage[ 'message' ] = $message;
        return $this;
    }
    /**
     *  Define o content-type do email
     *  @param string $contentType O tipo
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function type( $contentType )
    {
        $this->storage[ 'type' ] = $contentType;
        return $this;
    }
    /**
     *  Define a codificação do texto do email
     *  @param string $charset A codificação
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function charset( $charset )
    {
        $this->storage[ 'charset' ] = $charset;
        return $this;
    }
    /**
     *  Define prioridade do email
     *  @param int $priority A prioridade(1 mais baixa e 5 a mais alta)
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function priority( $priority )
    {
        $this->storage[ 'priority' ] = $priority;
        return $this;
    }
    /**
     *  Define o destinatário do email
     *  @param string $to O destinatário
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function addTo( $to )
    {
        $this->storage[ 'to' ] [ ] = $to;
        return $this;
    }
    /**
     *  Define o destinatário que receberá uma cópia do email
     *  @param string $Cc O destinatário da cópia
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function addCc( $Cc )
    {
        $this->storage[ 'Cc' ] [ ] = $Cc;
        return $this;
    }
    /**
     *  Define o(s) destinatário oculto que receberá uma cópia do email
     *  @param string $Bcc O destinatário da cópia
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function addBcc( $Bcc )
    {
        $this->storage[ 'Bcc' ] [ ] = $Bcc;
        return $this;
    }
    /**
     *  Adiciona um arquivo a ser anexado ao email
     *  @param string $attachment O caminho do anexo
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function addAttachment( Attachment $attachment )
    {
        if( $attachment instanceof Attachment )
        {
            $this->storage[ 'attachments' ] = $attachment;
            if( ! isset( $this->storage[ 'boundary' ] ) )
            {
                $this->storage[ 'boundary' ] = md5( uniqid( rand( ), true ) );
            }
        }
        return $this;
    }
    /**
     *  Insere o anexo ao corpo da mensagem do email
     *  @access private
     *  @return string A mensagem com os anexos
     */
    private function insertAttachment( )
    {
        $message = null;
        $attachments = $this->storage[ 'attachments' ]->__toArray( );
        for( $i = 0; $i < count( $attachments ); $i++ )
        {
            $file     = $attachments[ $i ];
            $message .= sprintf( 'Content-Type: %s; name="%s"%s', $file[ 'type' ], $file[ 'name' ], PHP_EOL );
            $message .= sprintf( 'Content-Transfer-Encoding: base64%s', PHP_EOL );
            $message .= sprintf( 'Content-Disposition: attachment; filename="%s"%s%s', $file[ 'name' ], PHP_EOL, PHP_EOL );
            $message .= sprintf( '%s%s', $file[ 'attachment' ], PHP_EOL );
            $message .= sprintf( '--%s%s%s', $this->storage[ 'boundary' ], ( ( ( $i + 1 ) == count( $attachments ) ) ? '--' : '' ), PHP_EOL );
        }
        return $message;
    }
    /**
     *  Prepara a mensagem com os anexos para o envio do email
     *  @access private
     *  @return string A mensagem preparada para o envio
     */
    private function prepareMessage( )
    {
        $message  = sprintf( '--%s%s', $this->storage[ 'boundary' ], PHP_EOL );
        $message .= sprintf( 'Content-Transfer-Encoding: 8bit%s', PHP_EOL );
        $message .= sprintf( 'Content-Type: %s; charset="%s"%s', $this->storage[ 'type' ], $this->storage[ 'charset' ], PHP_EOL );
        $message .= sprintf( '%s%s', $this->storage[ 'message' ], PHP_EOL );
        $message .= sprintf( '--%s%s', $this->storage[ 'boundary' ], PHP_EOL );
        $message .= self::insertAttachment( );
        return $message;
    }
    /**
     *  Monta os headers do email
     *  @access private
     *  @return array A propriedade resgatada
     */
    private function headers( )
    {
        $this->storage[ 'headers' ] [ ] = sprintf( 'Date: %s%s', date( "D, d M Y H:i:s O" ), PHP_EOL );
        $this->storage[ 'headers' ] [ ] = sprintf( 'Return-Path: %s%s', $this->storage[ 'from' ], PHP_EOL );
        $this->storage[ 'headers' ] [ ] = sprintf( 'From: %s%s', $this->storage[ 'from' ], PHP_EOL );
        $this->storage[ 'headers' ] [ ] = sprintf( 'To: %s%s', implode( ', ', $this->storage[ 'to' ] ), PHP_EOL );
        if( ! isset( $this->storage[ 'Cc' ] ) )
        {
            $this->storage[ 'headers' ] [ ] = sprintf( 'Cc: %s%s', implode( ', ', $this->storage[ 'Cc' ] ), PHP_EOL );
        }
        if( ! isset( $this->storage[ 'Bcc' ] ) )
        {
            $this->storage[ 'headers' ] [ ] = sprintf( 'Bcc: %s%s', implode( ', ', $this->storage[ 'Bcc' ] ), PHP_EOL );
        }
        $this->storage[ 'headers' ] [ ] = sprintf( 'Reply-To: %s%s', $this->storage[ 'from' ], PHP_EOL );
        $this->storage[ 'headers' ] [ ] = sprintf( 'Message-ID: <%s@%s>%s', md5( uniqid( rand( ), true ) ), $_SERVER[ 'HTTP_HOST' ], PHP_EOL );
        $this->storage[ 'headers' ] [ ] = sprintf( 'X-Priority: %d%s', $this->storage[ 'priority' ], PHP_EOL );
        $this->storage[ 'headers' ] [ ] = sprintf( 'X-Mailer: PHP/%s%s', phpversion( ), PHP_EOL );
        $this->storage[ 'headers' ] [ ] = sprintf( 'Disposition-Notification-To: %s%s', $this->storage[ 'from' ], PHP_EOL );
        $this->storage[ 'headers' ] [ ] = sprintf( 'MIME-Version: 1.0%s', PHP_EOL );
        if( ! isset( $this->storage[ 'attachments' ] ) )
        {
            $this->storage[ 'headers' ] [ ] = sprintf( 'Content-Transfer-Encoding: 8bit%s', PHP_EOL );
            $this->storage[ 'headers' ] [ ] = sprintf( 'Content-Type: %s; charset="%s"%s', $this->storage[ 'type' ], $this->storage[ 'charset' ], PHP_EOL );
        }
        else
        {
            $this->storage[ 'headers' ] [ ] = sprintf( 'Content-Type: multipart/mixed; boundary="%s"%s', $this->storage[ 'boundary' ], PHP_EOL );
        }
        return $this->storage[ 'headers' ];    
    }
    /**
     *  Monta o email e o envia
     *  @access public
     *  @return boolean true Em caso de sucesso
     */
    public function send( )
    {
        return @mail
        (
            null,
            $this->storage[ 'subject' ],
            ( ! isset( $this->storage[ 'attachments' ] ) ) ? $this->storage[ 'message' ] : self::prepareMessage( ),
            implode( null, self::headers( ) )
        );
    }
}
?>