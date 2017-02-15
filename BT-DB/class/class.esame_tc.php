<?php
class esame_tc
{
	private $_id_paziente;
	private $_id_inserimento;
	private $_extrassiale;
	private $_intrassiale;
	private $_dubbia;
	private $_contrasto;
	private $_tipo_contrasto;
	private $_sede;
	private $_id_esame_tc_array;
	private $_data_inserimento;
	private $_id;

	function __construct($id_paziente, $extrassiale, $intrassiale, $dubbia, $contrasto, $tipo_contrasto, $sede)
    {	
		$this->_id_paziente = $id_paziente;
		
        $this->_extrassiale = $extrassiale;
		$this->_intrassiale = $intrassiale;
		$this->_dubbia = $dubbia;
		$this->_contrasto = $contrasto;
		$this->_tipo_contrasto = $tipo_contrasto;
		$this->_sede = $sede;
    }


	public function insert()   // Insert the data of patient in the database:
    {
		global $error;
	
		$_id_paziente=$this->getID_paziente();
		$_extrassiale=$this->getExtrassiale();
		$_intrassiale=$this->getIntrassiale();
		$_dubbia=$this->getDubbia();
		$_contrasto=$this->getContrasto();
		$_tipo_contrasto=$this->getTipo_contrasto();
		$_sede=$this->getSede();
		$_data_inserimento=$this->getData_inserimento();
	
		$query = "INSERT INTO esame_tc
                (id, id_paziente, extrassiale, intrassiale, dubbia, contrasto, tipo_contrasto, sede, data_inserimento)
                VALUES
                (NULL, '$_id_paziente', '$_extrassiale', '$_intrassiale', '$_dubbia', '$_contrasto', '$_tipo_contrasto', '$_sede', '$_data_inserimento')";
        $rs = mysql_query($query);
	if ($rs == NULL)
		$error = 1;
	}


	public function retrive_by_id($id)   // Insert the data of patient in the database:
    {			
		$query = "SELECT id, extrassiale, intrassiale, dubbia, contrasto, tipo_contrasto, sede, data_inserimento FROM esame_tc WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id, $extrassiale, $intrassiale, $dubbia, $contrasto, $tipo_contrasto, $sede, $data_inserimento) = mysql_fetch_row($rs))
		{
			$this->setExtrassiale($extrassiale);
			$this->setIntrassiale($intrassiale);
			$this->setDubbia($dubbia);
			$this->setContrasto($contrasto);
			$this->setTipo_contrasto($tipo_contrasto);
			$this->setSede($sede);
			$this->setData_inserimento($data_inserimento);
		}		
	}
	
	
	public function retrive_by_id_paziente()   // Insert the data of patient in the database:
    {
		global $n_esame_tc;
	
		$_id_paziente=$this->getID_paziente();	
		
		$query = "SELECT id, extrassiale, intrassiale, dubbia, contrasto, tipo_contrasto, sede, data_inserimento FROM esame_tc WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		$n_esame_tc=0;
		while(list($id, $extrassiale, $intrassiale, $dubbia, $contrasto, $tipo_contrasto, $sede, $data_inserimento) = mysql_fetch_row($rs))
		{
			$this->setID_esame_tc_array($id, $n_esame_tc);
			$this->setID($id);
			$n_esame_tc = $n_esame_tc+1;
		}		
	}

	public function delete($id)   // Insert the data of patient in the database:
    {
		$query = "DELETE FROM esame_tc WHERE id='$id'";
		$rs = mysql_query($query);	
	}

	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM esame_tc WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}

	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM esame_tc WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM esame_tc WHERE $nome_colonna LIKE '%$valore%'";
			
		$rs = mysql_query($query);
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id);			
		}
	}
		
	// Functions SET ******************************************************
	public function setID_esame_tc_array($var, $n_esame_tc)
    {
		  $this->_id_esame_tc_array[$n_esame_tc] = $var;
    }	

	public function setData_inserimento($var)
    {
		  $this->_data_inserimento = $var;
    }			

	public function setExtrassiale($var)
    {
		  $this->_extrassiale = $var;
    }	
	
	public function setIntrassiale($var)
    {
		  $this->_intrassiale = $var;
    }	

	public function setDubbia($var)
    {
		  $this->_dubbia = $var;
    }	
	
	public function setContrasto($var)
    {
		  $this->_contrasto = $var;
    }

	public function setTipo_contrasto($var)
    {
		  $this->_tipo_contrasto = $var;
    }	

	public function setSede($var)
    {
		  $this->_sede = $var;
    }	
		
	public function setID($var)
    {
		  $this->_id = $var;
    }	

	public function setID_paziente($var)
    {
		  $this->_id_paziente = $var;
    }
			
	// Functions GET ******************************************************
	
    public function getID_paziente()
    {
    	return $this->_id_paziente;
    }

    public function getExtrassiale()
    {
    	return $this->_extrassiale;
    }

    public function getIntrassiale()
    {
    	return $this->_intrassiale;
    }

    public function getDubbia()
    {
    	return $this->_dubbia;
    }

    public function getContrasto()
    {
    	return $this->_contrasto;
    }

    public function getTipo_contrasto()
    {
    	return $this->_tipo_contrasto;
    }

    public function getSede()
    {
    	return $this->_sede;
    }

    public function getData_inserimento()
    {
    	return $this->_data_inserimento;
    }
	
	public function getID_esame_tc_array($n)
    {
    	return $this->_id_esame_tc_array[$n];
    }

	public function getID()
    {
    	return $this->_id;
    }	
	
	// *********
	public function __destruct()
    {}   
}
?>