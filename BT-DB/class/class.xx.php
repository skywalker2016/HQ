<?php
class xx
{
	private $_id_array;
	private $_id_paziente;
	private $_k_trans;	
	private $_vi;	
	private $_data_inserimento;
	
	function __construct($id_paziente, $k_trans, $vi)
    {	
		$this->_id_paziente = $id_paziente;
		
		if ($k_trans == NULL)
			$this->_k_trans= -1000; 
		else
			$this->_k_trans= $k_trans;

		if ($vi == NULL)
			$this->_vi= -1000; 
		else
			$this->_vi= $vi;
    }
	
	public function insert() 
    {
		global $error;
	
		$_id_paziente=$this->getID_paziente();
		$_k_trans=$this->getK_trans();
		$_vi=$this->getVi();
		$_data_inserimento=$this->getData_inserimento();

		$query = "INSERT INTO permeabilita
                (id, id_paziente, data_inserimento, k_trans, vi)
                VALUES
                (NULL, '$_id_paziente', '$_data_inserimento', '$_k_trans', '$_vi')";
       $rs = mysql_query($query);
	   	   
		if ($rs == NULL)
		$error = 1;
	}	
	
	public function retrive_by_id_paziente()
	{
		global $n_permeabilita;
		
		$_id_paziente=$this->getID_paziente();
		
		$query = "SELECT id FROM permeabilita WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		$n_permeabilita=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_array($id, $n_permeabilita);			
			$n_permeabilita = $n_permeabilita+1;
		}		
	}
	
	public function retrive_by_id($id)
    {
		$query = "SELECT id_paziente, data_inserimento, k_trans, vi  FROM permeabilita WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id_paziente, $data_inserimento, $k_trans, $vi) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id_paziente);				
			$this->setData_inserimento($data_inserimento);	
			$this->setK_trans($k_trans);	
			$this->setVi($vi);			
		}
	}
			
	public function delete($id)
    {
		$query = "DELETE FROM permeabilita WHERE id='$id'";
		$rs = mysql_query($query);	
	}
	
	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM permeabilita WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
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
	
	public function setK_trans($var)
	{
		$this->_k_trans= $var;
	}	
	
	public function setVi($var)
	{
		$this->_vi= $var;
	}	

	public function setData_inserimento($var)
	{
		$this->_data_inserimento= $var;
	}	

	
	// Functions GET ******************************************************
	
    public function getID_paziente()
    {
    	return $this->_id_paziente;
    }


    public function getK_trans()
    {
    	return $this->_k_trans;
    }
	
    public function getVi()
    {
    	return $this->_vi;
    }	

    public function getData_inserimento()
    {
    	return $this->_data_inserimento;
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