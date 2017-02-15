<?php
class tabella
{
	private $_id;
	private $_valore;
	private $_id_array;
	private $_nome_colonna;
	private $_nome_tabella;


	function __construct($nome_tabella, $nome_colonna)
	{		
		$this->_nome_tabella = $nome_tabella;	
		$this->_nome_colonna = $nome_colonna;
	}


	public function insert()
	{
		$_valore=$this->getValore();	
		$_nome_colonna=$this->getNome_colonna();
		$_nome_tabella=$this->getNome_tabella();

		$query = "INSERT INTO $_nome_tabella
		(id, $_nome_colonna)
		VALUES
		(NULL, '$_valore')";
		$rs = mysql_query($query);
	}

	public function retrive($flag)  
    	{	
		global $n_valori;
		
		$_nome_colonna=$this->getNome_colonna();
		$_nome_tabella=$this->getNome_tabella();

		if ($flag == 1) // recupera solo id per il conteggio degli utenti
			$query = "SELECT id, $_nome_colonna FROM $_nome_tabella";
		else if ($flag == 2) // recupera tutti i dati
		{
			$_id=$this->getID();
			$query = "SELECT id, $_nome_colonna FROM $_nome_tabella WHERE id='$_id' ORDER BY $_nome_colonna ASC";		
		}
		
		$rs = mysql_query($query);
		
		if ($flag == 1)
			$n_valori=0;
	
		while(list($id, $val) = mysql_fetch_row($rs))
		{
			if ($flag == 1)
				$this->setID_array($id, $n_valori);	
			
			$this->setID($id);
			$this->setValore($val);

			
			if ($flag == 1)
				$n_valori = $n_valori + 1;
		}
	}

	public function delete($id)
	{
		$_nome_tabella=$this->getNome_tabella();

		$query = "DELETE FROM $_nome_tabella WHERE id='$id'";
		$rs = mysql_query($query);	
	}	


	// Functions SET ******************************************************
	public function setID_array($id, $n)
	{
		$this->_id_array[$n]= $id;
	}	
		
	public function setID($var)
	{			
		$this->_id = $var;
	}

	public function setValore($var)
	{			
		global $error_44;
		
		if ($var == NULL)
			$error_44 = 1;
		else
			$this->_valore = $var;
	}


	// Functions GET ******************************************************
	public function getID_array($n)
	{
		return $this->_id_array[$n];
	}
	
	public function getID()
	{
		return $this->_id;
	}

	public function getValore()
	{
		return $this->_valore;
	}

	public function getNome_tabella()
	{
		return $this->_nome_tabella;
	}

	public function getNome_colonna()
	{
		return $this->_nome_colonna;
	}

	// *********
	public function __destruct()
   	 {}  
}
?>	