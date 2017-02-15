<?php
class rm_perfusione
{
	private $_id_paziente;
	private $_r_cbv;
	private $_valore_r_cbv;
	private $_data_inserimento;
	private $_id_rm_perfusione_array;

	
	function __construct($id_paziente, $id_inserimento, $r_cbv, $valore_r_cbv)
    	{	
		$this->_id_paziente = $id_paziente;
		$this->_r_cbv = $r_cbv;			

		if ($valore_r_cbv == NULL)
			$this->_valore_r_cbv = -1000;
		else
			$this->_valore_r_cbv = $valore_r_cbv;	
  	  }

	public function insert()   // Insert the data of patient in the database:
    	{
		global $error;
	
		$_id_paziente=$this->getID_paziente();
		$_data_inserimento=$this->getData_inserimento();
		$_r_cbv=$this->getR_cbv();
		$_valore_r_cbv=$this->getValore_r_cbv();
		

		$query = "INSERT INTO rm_perfusione
                (id, id_paziente, r_cbv, valore_r_cbv, data_inserimento)
                VALUES
                (NULL, '$_id_paziente', '$_r_cbv', '$_valore_r_cbv', '$_data_inserimento')";
     		  $rs = mysql_query($query);
	
		if ($rs == NULL)
		$error = 1;
	}
	

	public function retrive_by_id_paziente($id)
	{
		global $n_rm_perfusione;
		
		$query = "SELECT id, r_cbv, valore_r_cbv, data_inserimento FROM rm_perfusione WHERE id_paziente = '$id'";
		$rs = mysql_query($query);
		$n_rm_perfusione=0;
		while(list($id, $r_cbv, $valore_r_cbv, $data_inserimento) = mysql_fetch_row($rs))
		{
			$this->setID($id);
			$this->setID_rm_perfusione_array($id, $n_rm_perfusione);
			$this->setR_cbv($r_cbv);
			$this->setValore_r_cbv($valore_r_cbv);
			$this->setData_inserimento($data_inserimento);
			
			$n_rm_perfusione = $n_rm_perfusione+1;
		}		
	}

	public function retrive_by_id($id)
	{
		
		$query = "SELECT id_paziente, r_cbv, valore_r_cbv, data_inserimento FROM rm_perfusione WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id_paziente, $r_cbv, $valore_r_cbv, $data_inserimento) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id_paziente);
			$this->setR_cbv($r_cbv);
			$this->setValore_r_cbv($valore_r_cbv);
			$this->setData_inserimento($data_inserimento);;
		}		
	}

	public function delete($id)  
    {
		$query = "DELETE FROM rm_perfusione WHERE id='$id'";
		$rs = mysql_query($query);	
	}

	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM rm_perfusione WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}

	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM rm_perfusione WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM rm_perfusione WHERE $nome_colonna LIKE '%$valore%'";
			
		$rs = mysql_query($query);
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id);			
		}
	}
				
	// Function SET ********************************************************
	public function setID_paziente($var)
    	{
		 $this->_id_paziente = $var;
    	}	

	public function setID_rm_perfusione_array($var, $n)
    	{
		 $this->_id_rm_perfusione_array[$n] = $var;
    	}	

	public function setID($var)
    	{
		 $this->_id = $var;
    	}

	public function setR_cbv($var)
    	{
		 $this->_r_cbv = $var;
    	}

	public function setValore_r_cbv($var)
    	{
		 $this->_valore_r_cbv = $var;
    	}

	public function setData_inserimento($var)
    	{
		 $this->_data_inserimento = $var;
    	}


	// Functions GET ******************************************************
   public function getID_rm_perfusione_array($n)
    {
    	return $this->_id_rm_perfusione_array[$n];
    }


     public function getID_paziente()
    {
    	return $this->_id_paziente;
    }

     public function getData_inserimento()
    {
    	return $this->_data_inserimento;
    }

    public function getR_cbv()
    {
    	return $this->_r_cbv;
    }

    public function getValore_r_cbv()
    {
    	return $this->_valore_r_cbv;
    }

	// *********
	public function __destruct()
    	{}   
}
?>