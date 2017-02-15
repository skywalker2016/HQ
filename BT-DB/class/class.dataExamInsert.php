<?php

class dataExaminsert
{
	private $_id_data_inserimento;
	private $_data_inserimento; 
	private $_id_paziente; 
	
	public function __construct($date)
    {
		  $this->_data_inserimento = $date;
    }

	public function insert($id_paziente)   
    {
		global $error;	
	
		$_data_inserimento=$this->getData_inserimento();	
		$_data_inserimento=data_convert_for_mysql($_data_inserimento);	
	
		$query = "INSERT INTO inserimento
                (id, id_paziente, data_inserimento)
                VALUES
                (NULL, '$id_paziente', '$_data_inserimento')";
        $rs = mysql_query($query);
	
		 if ($rs == NULL)
		{
            // There is an error. It have not been possible to insert the date in the database:
            $error = 1;
        }		
		else	// In this case the database retrive the id from 'patient' table:
		{
			$this->retrive();
        }		
	}
	
	public function retrive()   // Retrive the data from table
    {
		// +++++++++ Retrive the information by Data_inserimento: ++++++++++++
		$_data_inserimento=$this->getData_inserimento();
		$_data_inserimento=data_convert_for_mysql($_data_inserimento);	
		
		$query = "SELECT id FROM inserimento WHERE data_inserimento = '$_data_inserimento'";
		$rs = mysql_query($query);
		while(list($id) = mysql_fetch_row($rs))
		{	
			$this->setID_inserimento($id);
		}
	}

	public function retrive_data()  
    {
		$_id_paziente=$this->getID_paziente();
	
		$query = "SELECT data_inserimento FROM inserimento WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		while(list($data) = mysql_fetch_row($rs))
		{	
			$this->setData_inserimento($data);
		}
	}

	public function retrive_data_by_id_inserimento($id)  
    {
		$query = "SELECT data_inserimento FROM inserimento WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($data) = mysql_fetch_row($rs))
		{	
			$this->setData_inserimento($data);
		}
	}

	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM inserimento WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}

	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM inserimento WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM inserimento WHERE $nome_colonna LIKE '%$valore%'";		
		$rs = mysql_query($query);
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id);			
		}
	}

	// SET functions ****************************************************
 	public function setID_inserimento($var)
    {
		  $this->_id_data_inserimento = $var;
    }	

 	public function setID_paziente($var)
    {
		  $this->_id_paziente = $var;
    }	

 	public function setData_inserimento($var)
    {
		  $this->_data_inserimento = $var;
    }
	
	// GET functions ****************************************************
	public function getID_data_inserimento()
    {
    	return $this->_id_data_inserimento;
    }
    public function getData_inserimento()
    {
     	return $this->_data_inserimento;

    }

    public function getID_paziente()
    {
     	return $this->_id_paziente;
    }
		
	// *********
	public function __destruct()
   {}   
}
?>