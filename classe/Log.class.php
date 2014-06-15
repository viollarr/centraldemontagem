<?php
class Log {
	private $fp;
	
	function __construct() {
		$this->fp = fopen('../'. '_log'.'/'. date('Y_m_d') . '_execucoes_RE.log', 'a');
	}
	
	function __destruct() {
		fwrite($this->fp, "\r\n");
		fwrite($this->fp, '-------------------------------');
		fwrite($this->fp, "\r\n");
		fclose($this->fp);
	}

	public  function grava($valor) {      		
		fwrite($this->fp, $valor . "\r\n");
	}
}
?>