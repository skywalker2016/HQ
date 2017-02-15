<?php

class sintomi
{
	private $_id_sintomi;
	private $_data_inserimento;
	private $_data_sintomi;
	private $_deficit;
	private $_deficit_motorio;	
	private $_crisi_epilettica;
	private $_note;
	private $_disturbi_comportamento;
	private $_cefalea;
	private $_sintomi_altro;
	
	private $_id_sintomi_array;

	public function __construct($date)
    { 
		  $this->_data_inserimento = $date;		
	}

	public function insert($id_paziente, $data_inserimento)   
    {
		global $error;	
		
		$_data_sintomi=$this->getData_sintomi();			
		$_deficit=$this->getDeficit();	
		$_deficit_motorio=$this->getDeficit_motorio();	
		$_crisi_epilettica=$this->getCrisi_epilettica();
		$_note=$this->getNote();	
		$_disturbi_comportamento=$this->getDisturbi_comportamento();			
		$_cefalea=$this->getCefalea();			
		$_sintomi_altro=$this->getSintomi_altro();						
	
		$query = "INSERT INTO sintomi
                (id, id_paziente, data_sintomi, deficit, crisi_epilettica, note, disturbi_comportamento, cefalea, altro, deficit_motorio, data_inserimento)
                VALUES
                (NULL, '$id_paziente', '$_data_sintomi', '$_deficit', '$_crisi_epilettica', '$_note', '$_disturbi_comportamento', '$_cefalea', '$_sintomi_altro', '$_deficit_motorio', '$data_inserimento')";
        $rs = mysql_query($query);
					
		 if ($rs == NULL)
		{
            // There is an error. It have not been possible to insert the date in the database:
            $error = 1;
        }		
		else;	// 
	}

	public function retrive_by_id($id_paziente) 
	{
		global $n_id_sintomi;	
	
		$query = "SELECT id, data_sintomi, deficit, crisi_epilettica, note, disturbi_comportamento,	cefalea, altro, deficit_motorio, data_inserimento FROM sintomi WHERE id_paziente = '$id_paziente'";
		$rs = mysql_query($query);
		$n_id_sintomi = 0;
		while(list($id, $data_sintomi, $deficit, $crisi_epilettica, $note, $disturbi_comportamento,	$cefalea, $altro, $deficit_motorio, $data_inserimento) = mysql_fetch_row($rs))
		{
			$this->setID_sintomi($id);
			$this->setData_sintomi($data_sintomi);	
			$this->setDeficit($deficit);
			$this->setCrisi_epilettica($crisi_epilettica);
			$this->setNote($note);			
			$this->setDisturbi_comportamento($disturbi_comportamento);	
			$this->setCefalea($cefalea);
			$this->setSintomi_altro($altro);								
			$this->setDeficit_motorio($deficit_motorio);
			$this->setData_inserimento($data_inserimento);
			
			$this->setID_sintomi_array($id, $n_id_sintomi);
			$n_id_sintomi = $n_id_sintomi + 1;
		}
	}

	public function retrive_by_id_sintomi($id_sintomi) 
	{	
		$query = "SELECT id, data_sintomi, deficit, crisi_epilettica, note, disturbi_comportamento,	cefalea, altro, deficit_motorio, data_inserimento FROM sintomi WHERE id = '$id_sintomi'";
		$rs = mysql_query($query);
		while(list($id, $data_sintomi, $deficit, $crisi_epilettica, $note, $disturbi_comportamento,	$cefalea, $altro, $deficit_motorio, $data_inserimento) = mysql_fetch_row($rs))
		{
			$this->setID_sintomi($id);
			$this->setData_sintomi($data_sintomi);	
			$this->setDeficit($deficit);
			$this->setCrisi_epilettica($crisi_epilettica);
			$this->setNote($note);			
			$this->setDisturbi_comportamento($disturbi_comportamento);	
			$this->setCefalea($cefalea);
			$this->setSintomi_altro($altro);								
			$this->setDeficit_motorio($deficit_motorio);
			$this->setData_inserimento($data_inserimento);
		}
	}
	
	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM sintomi WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}
	
	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM sintomi WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM sintomi WHERE $nome_colonna LIKE '%$valore%'";
		
		$rs = mysql_query($query);
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id);			
		}
	}
		
	// SET functions ****************************************************
 	public function setID_sintomi($var)
    {
		  $this->_id_sintomi = $var;
    }	

 	public function setData_inserimento($var)
    {
		  $this->_id_inserimento = $var;
    }
	
 	public function setDeficit($var)
    {
		  $this->_deficit = $var;
    }	

 	public function setDeficit_motorio($var)
    {
		  $this->_deficit_motorio = $var;
    }
	
 	public function setCrisi_epilettica($var)
    {
		  $this->_crisi_epilettica = $var;
    }	

 	public function setNote($var)
    {
		  $this->_note = $var;
    }	
	
	 public function setData_sintomi($var)
    {
		  $this->_data_sintomi = $var;
    }	

	 public function setDisturbi_comportamento($var)
    {
		  $this->_disturbi_comportamento = $var;
    }	
	
	 public function setCefalea($var)
    {
		  $this->_cefalea = $var;
    }		
	
	 public function setSintomi_altro($var)
    {
		  $this->_sintomi_altro = $var;
    }	

	 public function setID_paziente($var)
    {
		  $this->_id_paziente = $var;
    }	
	
	 public function setID_sintomi_array($var, $n_id_sintomi)
    {
		  $this->_id_sintomi_array[$n_id_sintomi] = $var;
    }		
		
	
	// GET functions ****************************************************
	public function getID_sintomi()
    {
    	return $this->_id_sintomi;
    }

	public function getData_inserimento()
    {
    	return $this->_id_inserimento;
    }
	
	public function getData_sintomi()
    {
    	return $this->_data_sintomi;
    }

	public function getDeficit()
    {
    	return $this->_deficit;
    }

	public function getDeficit_motorio()
    {
    	return $this->_deficit_motorio;
    }
		
	public function getCrisi_epilettica()
    {
    	return $this->_crisi_epilettica;
    }

	public function getNote()
    {
    	return $this->_note;
    }
	
	public function getDisturbi_comportamento()
    {
    	return $this->_disturbi_comportamento;
    }	
	
	public function getCefalea()
    {
    	return $this->_cefalea;
    }	

	public function getSintomi_altro()
    {
    	return $this->_sintomi_altro;
    }

	public function getID_paziente()
    {
    	return $this->_id_paziente;
    }
	
	public function getID_sintomi_array($n)
    {
    	return $this->_id_sintomi_array[$n];
    }
	
			
	// *********
	public function __destruct()
   {}  
}
?>