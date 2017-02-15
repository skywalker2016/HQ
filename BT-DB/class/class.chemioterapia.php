<?php
class chemioterapia
{
	private $_id_array;
	private $_id_paziente;
	private $_temozolomide;
	private $_data_temozolomide;
	private $_pc_v;
	private $_data_pc_v;
	private $_fotemustina;
	private $_data_fotemustina;
	private $_cicli_fotemustina;
	private $_cicli_temozolomide;
	private $_cicli_pc_v;
	private $_altro;	
	private $_data_altro;
	private $_terapia_supporto;
	private $_data_terapia_supporto;

	function __construct($id_paziente, $temozolomide, $data_temozolomide, $cicli_temozolomide, $pc_v, $data_pc_v, $cicli_pc_v, $fotemustina, $data_fotemustina, $cicli_fotemustina, $altro, $data_altro, $terapia_supporto, $data_terapia_supporto)
    {	
		$this->_id_paziente = $id_paziente;
		$this->_temozolomide = $temozolomide;
		
		if ($data_temozolomide == '--')
			$this->_data_temozolomide = '0000-00-00';
		else	
			$this->_data_temozolomide = $data_temozolomide;
		
		if ($cicli_temozolomide == NULL)
			$this->_cicli_temozolomide = -1000;
		else
			$this->_cicli_temozolomide = $cicli_temozolomide;
		
		$this->_pc_v = $pc_v;
		
		if ($data_pc_v == '--')
			$this->_data_pc_v = '0000-00-00';
		else	
			$this->_data_pc_v = $data_pc_v;
		
		if ($cicli_pc_v == NULL)
			$this->_cicli_pc_v = -1000;
		else
			$this->_cicli_pc_v = $cicli_pc_v;
			
		$this->_fotemustina = $fotemustina;
		
		if ($data_fotemustina == '--')
			$this->_data_fotemustina = '0000-00-00';
		else	
			$this->_data_fotemustina = $data_fotemustina;
				
		if ($cicli_fotemustina == NULL)
			$this->_cicli_fotemustina = -1000;
		else
			$this->_cicli_fotemustina = $cicli_fotemustina;
							
		$this->_altro = $altro;
		
		if ($data_altro == '--')
			$this->_data_altro = '0000-00-00';
		else	
			$this->_data_altro = $data_altro;
				
		$this->_terapia_supporto= $terapia_supporto;
		
		if ($data_terapia_supporto == '--')
			$this->_data_terapia_supporto = '0000-00-00';
		else	
			$this->_data_terapia_supporto= $data_terapia_supporto;
    }


	public function insert() 
    {
		global $error_chemio;
	
		$_id_paziente=$this->getID_paziente();		
		$_temozolomide=$this->getTemozolomide();
		$_data_temozolomide=$this->getData_temozolomide();
		$_cicli_temozolomide=$this->getCicli_temozolomide();
		$_pc_v=$this->getPc_v();
		$_data_pc_v=$this->getData_pc_v();
		$_cicli_pc_v=$this->getCicli_pc_v();
		$_fotemustina=$this->getFotemustina();
		$_data_fotemustina=$this->getData_fotemustina();
		$_cicli_fotemustina=$this->getCicli_fotemustina();
		$_altro=$this->getAltro();
		$_data_altro=$this->getData_altro();
		$_terapia_supporto=$this->getTerapia_supporto();
		$_data_terapia_supporto=$this->getData_terapia_supporto();

		$query = "INSERT INTO chemioterapia
                (id, id_paziente, temozolomide, data_temozolomide, cicli_temozolomide, pc_v, data_pc_v, cicli_pc_v, fotemustina, data_fotemustina, cicli_fotemustina, altro, data_altro, terapia_supporto, data_terapia_supporto)
                VALUES	
				(NULL, '$_id_paziente', '$_temozolomide', '$_data_temozolomide', '$_cicli_temozolomide', '$_pc_v', '$_data_pc_v', '$_cicli_pc_v', '$_fotemustina', '$_data_fotemustina', '$_cicli_fotemustina', '$_altro', '$_data_altro', '$_terapia_supporto', '$_data_terapia_supporto')";
       $rs = mysql_query($query);	   	   
		if ($rs == NULL)
			$error_chemio = 1;
	}

	public function retrive_by_id_paziente()
	{
		global $n_chemioterapia;
		
		$_id_paziente=$this->getID_paziente();
		
		$query = "SELECT id FROM chemioterapia WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		$n_chemioterapia=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_array($id, $n_chemioterapia);			
			$n_chemioterapia = $n_chemioterapia+1;
		}		
	}

	public function retrive_by_id($id)
    {
		$query = "SELECT id_paziente, temozolomide, data_temozolomide, cicli_temozolomide, pc_v, data_pc_v, cicli_pc_v, fotemustina, data_fotemustina, cicli_fotemustina, altro, data_altro, terapia_supporto, data_terapia_supporto FROM chemioterapia WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id_paziente, $temozolomide, $data_temozolomide, $cicli_temozolomide, $pc_v, $data_pc_v, $cicli_pc_v, $fotemustina, $data_fotemustina, $cicli_fotemustina, $altro, $data_altro, $terapia_supporto, $data_terapia_supporto) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id_paziente);				
			$this->setTemozolomide($temozolomide);
			$this->setData_temozolomide($data_temozolomide);
			$this->setCicli_temozolomide($cicli_temozolomide);	
			$this->setPc_v($pc_v);
			$this->setData_pc_v($data_pc_v);
			$this->setCicli_pc_v($cicli_pc_v);
			$this->setFotemustina($fotemustina);
			$this->setData_fotemustina($data_fotemustina);
			$this->setCicli_fotemustina($cicli_fotemustina);
			$this->setAltro($altro);
			$this->setData_altro($data_altro);
			$this->setTerapia_supporto($terapia_supporto);
			$this->setData_terapia_supporto($data_terapia_supporto);						
		}
	}


	// DELETE FUNCTIONS: ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	public function delete_temozolomide($id)  
    {
		$query = "UPDATE chemioterapia SET 
				temozolomide =  '', 
				data_temozolomide = '0000-00-00',
				cicli_temozolomide = '-1000'
				WHERE  id ='$id'";
		$rs = mysql_query($query);	
		
		// controllo:
		$this->check_delete($id);
	}

	public function delete_pc_v($id)  
    {
		$query = "UPDATE chemioterapia SET 
				pc_v =  '', 
				data_pc_v = '0000-00-00',
				cicli_pc_v = '-1000'
				WHERE  id ='$id'";
		$rs = mysql_query($query);	
		
		// controllo:
		$this->check_delete($id);
	}
	
	public function delete_fotemustina($id)  
    {
		$query = "UPDATE chemioterapia SET 
				fotemustina =  '', 
				data_fotemustina = '0000-00-00',
				cicli_fotemustina = '-1000'
				WHERE  id ='$id'";
		$rs = mysql_query($query);	
		
		// controllo:
		$this->check_delete($id);
	}	

	public function delete_altro($id)  
    {
		$query = "UPDATE chemioterapia SET 
				altro =  '', 
				data_altro = '0000-00-00'
				WHERE  id ='$id'";
		$rs = mysql_query($query);	
		
		// controllo:
		$this->check_delete($id);
	}
	
	public function delete_terapia_supporto($id)  
    {
		$query = "UPDATE chemioterapia SET 
				terapia_supporto =  '', 
				data_terapia_supporto = '0000-00-00'
				WHERE  id ='$id'";
		$rs = mysql_query($query);	
		
		// controllo:
		$this->check_delete($id);
	}

	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM chemioterapia WHERE id_paziente='$id'";
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
	
	public function setTemozolomide($var)
	{
		$this->_temozolomide = $var;
	}
		
	public function setData_temozolomide($var)
	{
		$this->_data_temozolomide= $var;
	}	
	
	public function setCicli_temozolomide($var)
	{
		$this->_cicli_temozolomide= $var;
	}	
	
	public function setPc_v($var)
	{
		$this->_pc_v= $var;
	}
	
	public function setData_pc_v($var)
	{
		$this->_data_pc_v= $var;
	}
	
	public function setCicli_pc_v($var)
	{
		$this->_cicli_pc_v= $var;
	}
	
	public function setFotemustina($var)
	{
		$this->_fotemustina= $var;
	}
	
	public function setData_fotemustina($var)
	{
		$this->_data_fotemustina= $var;
	}
	
	public function setCicli_fotemustina($var)
	{
		$this->_cicli_fotemustina= $var;
	}
	
	public function setAltro($var)
	{
		$this->_altro= $var;
	}
	
	public function setData_altro($var)
	{
		$this->_data_altro= $var;
	}

	public function setTerapia_supporto($var)
	{
		$this->_terapia_supporto= $var;
	}
	
	public function setData_terapia_supporto($var)
	{
		$this->_data_terapia_supporto= $var;
	}


	// Functions GET ******************************************************
    public function getID_paziente()
    {
    	return $this->_id_paziente;
    }

    public function getTemozolomide()
    {
    	return $this->_temozolomide;
    }

    public function getData_temozolomide()
    {
    	return $this->_data_temozolomide;
    }

    public function getCicli_temozolomide()
    {
    	return $this->_cicli_temozolomide;
    }

    public function getPc_v()
    {
    	return $this->_pc_v;
    }

    public function getData_pc_v()
    {
    	return $this->_data_pc_v;
    }

    public function getCicli_pc_v()
    {
    	return $this->_cicli_pc_v;
    }

    public function getFotemustina()
    {
    	return $this->_fotemustina;
    }
	
    public function getData_fotemustina()
    {
    	return $this->_data_fotemustina;
    }	
	
    public function getCicli_fotemustina()
    {
    	return $this->_cicli_fotemustina;
    }	
	
    public function getAltro()
    {
    	return $this->_altro;
    }
	
    public function getData_altro()
    {
    	return $this->_data_altro;
    }		
		
    public function getTerapia_supporto()
    {
    	return $this->_terapia_supporto;
    }
	
    public function getData_terapia_supporto()
    {
    	return $this->_data_terapia_supporto;
    }		
	
    public function getID_array($n)
    {
    	return $this->_id_array[$n];
    }
	

		function check_delete($id)
		{
			$query = "SELECT temozolomide, pc_v, fotemustina, altro, terapia_supporto FROM chemioterapia WHERE id = '$id'";
			$rs = mysql_query($query);
			while(list($var1, $var2, $var3, $var4, $var5) = mysql_fetch_row($rs))
			{
				if ( ($var1 != 'on') && ($var2 != 'on') && ($var3 != 'on') && ($var4 == '' ) && ($var5 == '') ) 
				{	
					$query1 = "DELETE FROM chemioterapia WHERE id='$id'";
					$rs1 = mysql_query($query1);					
				}
			}
		}
	
	
	// *********
	public function __destruct()
    {}  
}
?>