<?php
class rm_dti
{
	private $_id_paziente;
	private $_data_inserimento;
	private $_valore_fa;
	private $_cortico_spinale;
	private $_arcuato;
	private $_longitudinale_inferiore;
	private $_vie_ottiche;
	private $_id_array;

	
	function __construct($id_paziente, $valore_fa, $cortico_spinale, $arcuato, $longitudinale_inferiore, $vie_ottiche)
    {	
		$this->_id_paziente = $id_paziente;
	
		if ($valore_fa == NULL)
			$this->_valore_fa= -1000;
		else
			$this->_valore_fa = $valore_fa;	
   
   		$this->_cortico_spinale = $cortico_spinale;
   		$this->_arcuato = $arcuato;
   		$this->_longitudinale_inferiore = $longitudinale_inferiore;
   		$this->_vie_ottiche= $vie_ottiche;
    }
	
	public function insert()   // Insert the data of patient in the database:
    {
		global $error;
	
		$_id_paziente=$this->getID_paziente();
		$_data_inserimento=$this->getData_inserimento();
		$_valore_fa=$this->getValore_fa();
		$_cortico_spinale=$this->getCortico_spinale();
		$_arcuato=$this->getArcuato();
		$_longitudinale_inferiore=$this->getLongitudinale_inferiore();
		$_vie_ottiche=$this->getVie_ottiche();

		$query = "INSERT INTO rm_dti
                (id, id_paziente, data_inserimento, valore_fa, cortico_spinale, arcuato, longitudinale_inferiore, vie_ottiche)
                VALUES
                (NULL, '$_id_paziente', '$_data_inserimento', '$_valore_fa', '$_cortico_spinale', '$_arcuato', '$_longitudinale_inferiore', '$_vie_ottiche')";
       $rs = mysql_query($query);

		if ($rs == NULL)
		$error = 1;
	}

	public function retrive_by_id_paziente()
	{
		global $n_rm_dti;
		
		$_id_paziente=$this->getID_paziente();
		
		$query = "SELECT id FROM rm_dti WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		$n_rm_dti=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_array($id, $n_rm_dti);			
			$n_rm_dti = $n_rm_dti+1;
		}		
	}


	public function retrive_by_id($id)
    {
		$query = "SELECT id_paziente,data_inserimento, valore_fa, cortico_spinale, arcuato,	longitudinale_inferiore,vie_ottiche FROM rm_dti WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id_paziente,$data_inserimento, $valore_fa, $cortico_spinale, $arcuato,	$longitudinale_inferiore, $vie_ottiche) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id_paziente);
			$this->setData_inserimento($data_inserimento);			
			$this->setValore_fa($valore_fa);	
			$this->setCortico_spinale($cortico_spinale);	
			$this->setArcuato($arcuato);	
			$this->setLongitudinale_inferiore($longitudinale_inferiore);	
			$this->setVie_ottiche($vie_ottiche);													
		}
	}

	public function delete($id)   // Insert the data of patient in the database:
    {
		$query = "DELETE FROM rm_dti WHERE id='$id'";
		$rs = mysql_query($query);	
	}

	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM rm_dti WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}
	
	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM rm_dti WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM rm_dti WHERE $nome_colonna LIKE '%$valore%'";
			
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
			
	public function setValore_fa($var)
	{
	$this->_valore_fa= $var;
	}		

	public function setCortico_spinale($var)
	{
	$this->_cortico_spinale= $var;
	}	

	public function setArcuato($var)
	{
	$this->_arcuato= $var;
	}

	public function setLongitudinale_inferiore($var)
	{
	$this->_longitudinale_inferiore= $var;
	}
	
	public function setVie_ottiche($var)
	{
	$this->_vie_ottiche= $var;
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

    public function getValore_fa()
    {
    	return $this->_valore_fa;
    }

    public function getCortico_spinale()
    {
    	return $this->_cortico_spinale;
    }

    public function getArcuato()
    {
    	return $this->_arcuato;
    }

    public function getLongitudinale_inferiore()
    {
    	return $this->_longitudinale_inferiore;
    }

    public function getVie_ottiche()
    {
    	return $this->_vie_ottiche;
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