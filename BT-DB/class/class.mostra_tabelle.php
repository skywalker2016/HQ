<?php
class mostra_tabelle
{
	private $_nome_tabella;
	private $_numero_tabelle;

	function __construct()
	{}



	public function retrive()
	{
		$n=0;
		$query = "SHOW TABLES FROM my_tumorsdatabase";
		$rs = mysql_query($query);
		while(list($table) = mysql_fetch_row($rs))
		{	
			// controllo sulle tabelle:
			if ( ($table == 'user') || ($table == 'patient') || ($table == 'sede') || ($table == 'try_date') || ($table == 'tumori_principali') );
			else
			{
				$this->setNome_tabella($table, $n);
				$n = $n+1;
			}
		}
		$this->setNumero_tabelle($n);
	}




	public function setNome_tabella($var, $n)
	{			
		$this->_nome_tabella[$n] = $var;
	}
	
	
	public function setNumero_tabelle($var)
	{			
		$this->_numero_tabelle = $var;
	}
	

	public function getNome_tabella($n)
	{
	return $this->_nome_tabella[$n];
	}		

	public function getNumero_tabelle()
	{
	return $this->_numero_tabelle;
	}

	
	// *********
	public function __destruct()
	{}  

}
?>