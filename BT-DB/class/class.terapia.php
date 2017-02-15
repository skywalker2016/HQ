<?php
class terapia
{
	private $_id_array;
	private $_id_paziente;
	private $_rt_conformazionale;
	private $_data_rt_conformazionale;
	private $_radiochirurgia;
	private $_data_radiochirurgia;

	function __construct($id_paziente, $rt_conformazionale, $data_rt_conformazionale, $radiochirurgia, $data_radiochirurgia)
    {	
		$this->_id_paziente = $id_paziente;
		$this->_rt_conformazionale = $rt_conformazionale;
		
		if ($data_rt_conformazionale == '--')
			$this->_data_rt_conformazionale = '0000-00-00';
		else	
			$this->_data_rt_conformazionale = $data_rt_conformazionale;
		
		$this->_radiochirurgia = $radiochirurgia;
		
		if ($data_radiochirurgia == '--')
			$this->_data_radiochirurgia = '0000-00-00';
		else			
			$this->_data_radiochirurgia = $data_radiochirurgia;
    }


	public function insert() 
    {
		global $error;
	
		$_id_paziente=$this->getID_paziente();
		$_rt_conformazionale=$this->getRt_conformazionale();
		$_data_rt_conformazionale=$this->getData_rt_conformazionale();
		$_radiochirurgia =$this->getRadiochirurgia ();
		$_data_radiochirurgia=$this->getData_radiochirurgia();

		$query = "INSERT INTO terapia
                (id, id_paziente, rt_conformazionale, data_rt_conformazionale, radiochirurgia, data_radiochirurgia)
                VALUES
                (NULL, '$_id_paziente', '$_rt_conformazionale', '$_data_rt_conformazionale', '$_radiochirurgia', '$_data_radiochirurgia')";
       $rs = mysql_query($query);
	   	   
		if ($rs == NULL)
		$error = 1;
	}

	public function retrive_by_id_paziente()
	{
		global $n_terapia;
		
		$_id_paziente=$this->getID_paziente();
		
		$query = "SELECT id FROM terapia WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		$n_terapia=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_array($id, $n_terapia);			
			$n_terapia = $n_terapia+1;
		}		
	}

	public function retrive_by_id($id)
    {
		$query = "SELECT id_paziente, rt_conformazionale, data_rt_conformazionale, radiochirurgia, data_radiochirurgia FROM terapia WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id_paziente, $rt_conformazionale, $data_rt_conformazionale, $radiochirurgia, $data_radiochirurgia) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id_paziente);		
			$this->setRt_conformazionale($rt_conformazionale);
			$this->setData_rt_conformazionale($data_rt_conformazionale);
			$this->setRadiochirurgia($radiochirurgia);
			$this->setData_radiochirurgia($data_radiochirurgia);							
		}
	}

	public function delete_rt_conformazionale($id)   // Insert the data of patient in the database:
    {
		$query = "UPDATE terapia SET 
				rt_conformazionale =  '', 
				data_rt_conformazionale = '0000-00-00' 
				WHERE  id ='$id'";
		$rs = mysql_query($query);	
		
		// controlla se esiste la radiochirurgia, altrimenti cancella completamente la riga associate a questo ID:
		$query = "SELECT radiochirurgia FROM terapia WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($radiochirurgia) = mysql_fetch_row($rs))
		{
			if ($radiochirurgia != 'on')
			{	
				$query1 = "DELETE FROM terapia WHERE id='$id'";
				$rs1 = mysql_query($query1);					
			}
		}	
	}

	public function delete_radiochirurgia($id)   // Insert the data of patient in the database:
    {
		$query = "UPDATE terapia SET 
				radiochirurgia =  '', 
				data_radiochirurgia = '0000-00-00' 
				WHERE  id ='$id'";
		$rs = mysql_query($query);	
		
		// controlla se esiste la radiochirurgia, altrimenti cancella completamente la riga associate a questo ID:
		$query = "SELECT rt_conformazionale FROM terapia WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($rt_conformazionale) = mysql_fetch_row($rs))
		{
			if ($rt_conformazionale != 'on')
			{	
				$query1 = "DELETE FROM terapia WHERE id='$id'";
				$rs1 = mysql_query($query1);					
			}
		}
	
	}

	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM terapia WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}
		
	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM terapia WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM terapia WHERE $nome_colonna LIKE '%$valore%'";
			
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
	
	public function setRt_conformazionale($var)
	{
		$this->_rt_conformazionale= $var;
	}
	
	public function setData_rt_conformazionale($var)
	{
		$this->_data_rt_conformazionale= $var;
	}
		
	public function setRadiochirurgia($var)
	{
		$this->_radiochirurgia= $var;
	}
	
	public function setData_radiochirurgia($var)
	{
		$this->_data_radiochirurgia= $var;
	}	
	

	// Functions GET ******************************************************
    public function getID_paziente()
    {
    	return $this->_id_paziente;
    }

    public function getRt_conformazionale()
    {
    	return $this->_rt_conformazionale;
    }
	
    public function getData_rt_conformazionale()
    {
    	return $this->_data_rt_conformazionale;
    }
	
    public function getRadiochirurgia()
    {
    	return $this->_radiochirurgia;
    }

    public function getData_radiochirurgia()
    {
    	return $this->_data_radiochirurgia;
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