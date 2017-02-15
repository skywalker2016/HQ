<?php
class istologia
{
	private $_id_array;
	private $_id_paziente;
	private $_tumore;
	private $_note_tumore;
	private $_data_risultato;

	function __construct($id_paziente, $tumore, $note_tumore)
    {	
		$this->_id_paziente = $id_paziente;
		$this->_tumore = $tumore;
		$this->_note_tumore = $note_tumore;
    }

	public function insert() 
    {
		global $error;
	
		$_id_paziente=$this->getID_paziente();
		$_tumore=$this->getTumore();
		$_note_tumore=$this->getNote_tumore();
		$_data_risultato=$this->getData_risultato();

		$query = "INSERT INTO istologia
                (id, id_paziente, data_risultato, nome_tumore, note)
                VALUES
                (NULL, '$_id_paziente', '$_data_risultato', '$_tumore', '$_note_tumore')";
			
       $rs = mysql_query($query);	   
		if ($rs == NULL)
		$error = 1;
	}

	public function retrive_by_id_paziente()
	{
		global $n_istologia;
		
		$_id_paziente=$this->getID_paziente();
		
		$query = "SELECT id FROM istologia WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		$n_istologia=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_array($id, $n_istologia);			
			$n_istologia = $n_istologia+1;
		}		
	}

	public function retrive_by_nome_tumore($nome_tumore)
	{
		global $n_istologia;
		
		$query = "SELECT id_paziente FROM istologia WHERE nome_tumore = '$nome_tumore'";
		$rs = mysql_query($query);
		$n_istologia=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_array($id, $n_istologia);			
			$n_istologia = $n_istologia+1;
		}		
	}
	
	
	public function retrive_by_id($id)
    {
		$query = "SELECT id_paziente, data_risultato, nome_tumore, note FROM istologia WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id_paziente, $data_risultato, $tumore, $note_tumore) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id_paziente);
			$this->setData_risultato($data_risultato);			
			$this->setTumore($tumore);
			$this->setNote_tumore($note_tumore);													
		}
	}

	public function delete($id)   // Insert the data of patient in the database:
    {
		$query = "DELETE FROM istologia WHERE id='$id'";
		$rs = mysql_query($query);	
	}
	
	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM istologia WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}
	
	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM istologia WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM istologia WHERE $nome_colonna LIKE '%$valore%'";
			
		$rs = mysql_query($query);
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id);			
		}
	}
			
	// Funzioni SET: *****************************************************
	public function setID_paziente($var)
	{
		$this->_id_paziente= $var;
	}

	public function setID_array($id, $n)
	{
		$this->_id_array[$n]= $id;
	}	
	
	public function setData_risultato($var)
	{
		$this->_data_risultato= $var;
	}

	public function setTumore($var)
	{
		$this->_tumore= $var;
	}

	public function setNote_tumore($var)
	{
		$this->_note_tumore= $var;
	}

	// Functions GET ******************************************************
    public function getID_paziente()
    {
    	return $this->_id_paziente;
    }

    public function getData_risultato()
    {
    	return $this->_data_risultato;
    }

    public function getTumore()
    {
    	return $this->_tumore;
    }
	
    public function getNote_tumore()
    {
    	return $this->_note_tumore;
    }	
			
    public function getID_array($n)
    {
    	return $this->_id_array[$n];
    }	
	
	// *********
	public function __destruct()
    {}  
}
?>