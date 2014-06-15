<?php 
/**
 *  Classe que prepara os arquivos  
 *  a serem anexados a mensagem do email
 *  Created on 2011-07-16
 *  PHP version 5.3.0 and later
 *  @author Carlos Coelho <coelhoduda@hotmail.com>
 *  @version 0.1
 */
final class Attachment
{
    /**
     *  @var array Armazena todos os parâmetros do anexo
     *  @access private
     */
    private $storage;
    /**
     *  O construtor da classe Attachment
     *  @param string $attachment opcional O caminho do anexo
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function __construct( $attachment = null )
    {
        if( ! is_null( $attachment ) )
        {
            $this->storage[ ] = self::mimeType( $attachment );
        }
        return $this;
    }
    /**
     *  Adiciona um arquivo a ser anexado ao email
     *  @param string $attachment O caminho do anexo
     *  @access public
     *  @return array A propriedade resgatada
     */
    public function addAttachment( $attachment )
    {
        $this->storage[ ] = self::mimeType( $attachment );
        return $this;
    }
    /**
     *  Obt&eacute;m as informações do arquivo a ser anexado
     *  @param string $file O caminho do arquivo
     *  @access private
     *  @return array As informações necessárias para anexar o arquivo
     */
    private function mimeType( $file )
    {
        $finfo                = finfo_open( FILEINFO_MIME_TYPE );
        $info[ 'type' ]       = finfo_file( $finfo, realpath( $file ) );    
        $info[ 'name' ]       = $file;
        $info[ 'attachment' ] = self::base64( $file );
        finfo_close( $finfo );
        return $info;
    }
    /**
     *  Codifica o arquivo a ser anexado
     *  @param string $file O caminho do arquivo
     *  @access private
     *  @return string A string dividida
     */
    private function base64( $file )
    {
        $filename   = fopen( $file, 'r' );
        $attachment = fread( $filename, filesize( $file ) );
        fclose( $filename );
        return chunk_split( base64_encode( $attachment ) );
    }
    /**
    *  Conta o número de anexos
    *  @access public
    *  @return integer
    */
    public function count( )
    {
        return count( $this->storage );
    }
    /**
    *  Converte o objeto para sua representação em array
    *  @access public
    *  @return array
    */
    public function __toArray( )
    {
        for( $i = 0; $i < self::count( ); $i++ )
        {
            $array[ ] = $this->storage[ $i ];
        }
        return $array;
    }
}
?>