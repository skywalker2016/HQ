<?php
class intervento
{
	private $_id_paziente;
	private $_data_inserimento;
	private $_biopsia;
	private $_data_biopsia;
	private $_resezione_totale;
	private $_data_resezione_totale;
	private $_resezione_parziale;
	private $_data_resezione_parziale;
	private $_resezione_gliadel;
	private $_data_resezione_gliadel;
	private $_id_array;

	function __construct($id_paziente, $biopsia, $data_biopsia, $resezione_totale, $data_resezione_totale, $resezione_parziale, $data_resezione_parziale,$resezione_gliadel, $data_resezione_gliadel)
    {	
		$this->_id_paziente = $id_paziente;
		$this->_biopsia = $biopsia;
		$this->_data_biopsia = $data_biopsia;
		$this->_resezione_totale = $resezione_totale;
		$this->_data_resezione_totale = $data_resezione_totale;
		$this->_resezione_parziale = $resezione_parziale;
		$this->_data_resezione_parziale = $data_resezione_parziale;		
		$this->_resezione_gliadel = $resezione_gliadel;
		$this->_data_resezione_gliadel = $data_resezione_gliadel;
    }

	public function insert()   // Insert the data of patient in the database:
    {
		global $error;
	
		$_id_paziente=$this->getID_paziente();
		$_data_inserimento=$this->getData_inserimento();
		$_biopsia=$this->getBiopsia();
		$_data_biopsia=$this->getData_biopsia();
		$_resezione_totale=$this->getResezione_totale();
		$_data_resezione_totale=$this->getData_resezione_totale();
		$_resezione_parziale=$this->getResezione_parziale();
		$_data_resezione_parziale=$this->getData_resezione_parziale();
		$_resezione_gliadel=$this->getResezione_gliadel();
		$_data_resezione_gliadel=$this->getData_resezione_gliadel();

		$query = "INSERT INTO intervento
                (id, id_paziente, data_inserimento, biopsia,	data_biopsia,	resezione_totale,	data_resezione_totale,	resezione_parziale,	data_resezione_parziale,	resezione_gliadel,	data_resezione_gliadel)
                VALUES
                (NULL, '$_id_paziente', '$_data_inserimento', '$_biopsia',	'$_data_biopsia',	'$_resezione_totale',	'$_data_resezione_totale',	'$_resezione_parziale',	'$_data_resezione_parziale',	'$_resezione_gliadel',	'$_data_resezione_gliadel')";
       $rs = mysql_query($query);
	   	   
		if ($rs == NULL)
		$error = 1;
	}

	public function retrive_by_id_paziente()
	{
		global $n_intervento;
		
		$_id_paziente=$this->getID_paziente();
		
		$query = "SELECT id FROM intervento WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		$n_intervento=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_array($id, $n_intervento);			
			$n_intervento = $n_intervento+1;
		}		
	}
	
	public function retrive_by_id($id)
    {
		$query = "SELECT id_paziente, data_inserimento, biopsia,	data_biopsia,	resezione_totale,	data_resezione_totale,	resezione_parziale,	data_resezione_parziale,	resezione_gliadel,	data_resezione_gliadel FROM intervento WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id_paziente,$data_inserimento, $biopsia,	$data_biopsia,	$resezione_totale,	$data_resezione_totale,	$resezione_parziale,	$data_resezione_parziale,	$resezione_gliadel,	$data_resezione_gliadel) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id_paziente);
			$this->setData_inserimento($data_inserimento);			
			$this->setBiopsia($biopsia);	
			$this->setData_biopsia($data_biopsia);	
			$this->setResezione_totale($resezione_totale);	
			$this->setData_resezione_totale($data_resezione_totale);	
			$this->setResezione_parziale($resezione_parziale);	
			$this->setData_resezione_parziale($data_resezione_parziale);	
			$this->setResezione_gliadel($resezione_gliadel);	
			$this->setData_resezione_gliadel($data_resezione_gliadel);										
		}
	}	

	public function delete($id)   // Insert the data of patient in the database:
    {
		$query = "DELETE FROM intervento WHERE id='$id'";
		$rs = mysql_query($query);	
	}

	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM intervento WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}
	
	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM intervento WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM intervento WHERE $nome_colonna LIKE '%$valore%'";
			
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
		
	public function setData_inserimento($var)
	{
		$this->_data_inserimento= $var;
	}	

	public function setID_array($id, $n)
	{
		$this->_id_array[$n]= $id;
	}			

	public function setBiopsia($var)
	{
		$this->_biopsia= $var;
	}		
	
	public function setData_biopsia($var)
	{
		$this->_data_biopsia= $var;
	}		
	
	public function setResezione_totale($var)
	{
		$this->_resezione_totale= $var;
	}		
	
	public function setData_resezione_totale($var)
	{
		$this->_data_resezione_totale= $var;
	}		
	
	public function setResezione_parziale($var)
	{
		$this->_resezione_parziale= $var;
	}		
	
	public function setData_resezione_parziale($var)
	{
		$this->_data_resezione_parziale= $var;
	}	
	
	public function setResezione_gliadel($var)
	{
		$this->_resezione_gliadel= $var;
	}		
	
	public function setData_resezione_gliadel($var)
	{
		$this->_data_resezione_gliadel= $var;
	}	

// Functions GET ******************************************************
    public function getID_paziente()
    {
    	return $this->_id_paziente;
    }

    public function getData_inserimento()
    {
    	return $this->_data_inserimento;
    }

    public function getBiopsia()
    {
    	return $this->_biopsia;
    }

    public function getData_biopsia()
    {
    	return $this->_data_biopsia;
    }

    public function getResezione_totale()
    {
    	return $this->_resezione_totale;
    }

    public function getData_resezione_totale()
    {
    	return $this->_data_resezione_totale;
    }

    public function getResezione_parziale()
    {
    	return $this->_resezione_parziale;
    }
	
    public function getData_resezione_parziale()
    {
    	return $this->_data_resezione_parziale;
    }

    public function getResezione_gliadel()
    {
    	return $this->_resezione_gliadel;
    }
	
    public function getData_resezione_gliadel()
    {
    	return $this->_data_resezione_gliadel;
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