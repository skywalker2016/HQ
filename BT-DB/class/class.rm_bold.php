<?php
class rm_bold
{
	private $_id_paziente;
	private $_data_inserimento;
	private $_motorio_sede;
	private $_motorio_anteriore;
	private $_motorio_posteriore;
	private $_motorio_mediale;
	private $_motorio_intralesionale;
	private $_motorio_laterale;
	private $_motorio_inferiore;
	private $_motorio_superiore;
	private $_motorio_altro;
	private $_sensitiva_sede;
	private $_sensitiva_anteriore;
	private $_sensitiva_posteriore;
	private $_sensitiva_mediale;
	private $_sensitiva_intralesionale;
	private $_sensitiva_laterale;
	private $_sensitiva_inferiore;
	private $_sensitiva_superiore;
	private $_sensitiva_altro;
	private $_linguaggio_broca;
	private $_linguaggio_wermicke;
	private $_id_array;

	function __construct($id_paziente, $motorio_sede, $motorio_anteriore, $motorio_posteriore, $motorio_mediale, $motorio_intralesionale,$motorio_laterale ,$motorio_inferiore, $motorio_superiore, $motorio_altro, $sensitiva_sede, $sensitiva_anteriore, $sensitiva_posteriore, $sensitiva_mediale, $sensitiva_intralesionale ,$sensitiva_laterale ,$sensitiva_inferiore, $sensitiva_superiore, $sensitiva_altro, $linguaggio_broca, $linguaggio_wermicke, $sensitiva_area_altro)	
    {	
		$this->_id_paziente = $id_paziente;
		$this->_motorio_sede=$motorio_sede;
		$this->_motorio_anteriore=$motorio_anteriore;
		$this->_motorio_posteriore=$motorio_posteriore;
		$this->_motorio_mediale=$motorio_mediale;
		$this->_motorio_intralesionale=$motorio_intralesionale;
		$this->_motorio_laterale=$motorio_laterale;
		$this->_motorio_inferiore=$motorio_inferiore;
		$this->_motorio_superiore=$motorio_superiore;
		$this->_motorio_altro=$motorio_altro;
		$this->_sensitiva_anteriore=$sensitiva_anteriore;
		$this->_sensitiva_posteriore=$sensitiva_posteriore;
		$this->_sensitiva_mediale=$sensitiva_mediale;
		$this->_sensitiva_intralesionale=$sensitiva_intralesionale;
		$this->_sensitiva_laterale=$sensitiva_laterale;
		$this->_sensitiva_inferiore=$sensitiva_inferiore;
		$this->_sensitiva_superiore=$sensitiva_superiore;
		$this->_sensitiva_altro=$sensitiva_altro;
		$this->_linguaggio_broca=$linguaggio_broca;
		$this->_linguaggio_wermicke=$linguaggio_wermicke;
	
		if ($sensitiva_area_altro != NULL)
			$this->_sensitiva_sede=$sensitiva_area_altro;	
		else
			$this->_sensitiva_sede=$sensitiva_sede;
    }

	public function insert()   // Insert the data of patient in the database:
    {
		global $error;
	
		$_id_paziente=$this->getID_paziente();
		$_data_inserimento=$this->getData_inserimento();
		$_motorio_sede=$this->getMotorio_sede();
		$_motorio_anteriore=$this->getMotorio_anteriore();
		$_motorio_posteriore=$this->getMotorio_posteriore();
		$_motorio_mediale=$this->getMotorio_mediale();
		$_motorio_intralesionale=$this->getMotorio_intralesionale();
		$_motorio_laterale=$this->getMotorio_laterale();
		$_motorio_inferiore=$this->getMotorio_inferiore();
		$_motorio_superiore=$this->getMotorio_superiore();
		$_motorio_altro=$this->getMotorio_altro();
		$_sensitiva_sede=$this->getSensitiva_sede();
		$_sensitiva_anteriore=$this->getSensitiva_anteriore();
		$_sensitiva_posteriore=$this->getSensitiva_posteriore();
		$_sensitiva_mediale=$this->getSensitiva_mediale();
		$_sensitiva_intralesionale=$this->getSensitiva_intralesionale();
		$_sensitiva_laterale=$this->getSensitiva_laterale();
		$_sensitiva_inferiore=$this->getSensitiva_inferiore();
		$_sensitiva_superiore=$this->getSensitiva_superiore();
		$_sensitiva_altro=$this->getSensitiva_altro();
		$_linguaggio_broca=$this->getLinguaggio_broca();
		$_linguaggio_wermicke=$this->getLinguaggio_wermicke();

		$query = "INSERT INTO rm_bold
                		(id,
				id_paziente,
				data_inserimento,
				motorio_sede,
				motorio_anteriore,
				motorio_posteriore,
				motorio_mediale,
				motorio_intralesionale,
				motorio_laterale,
				motorio_inferiore,
				motorio_superiore,
				motorio_altro,
				sensitiva_sede,
				sensitiva_anteriore,
				sensitiva_posteriore,
				sensitiva_mediale,
				sensitiva_intralesionale,
				sensitiva_laterale,
				sensitiva_inferiore,
				sensitiva_superiore,
				sensitiva_altro,
				linguaggio_broca,
				linguaggio_wernicke)
            		 VALUES
               			 (NULL, 
				'$_id_paziente', 
				'$_data_inserimento', 
				'$_motorio_sede',
				'$_motorio_anteriore',
				'$_motorio_posteriore',
				'$_motorio_mediale',
				'$_motorio_intralesionale',
				'$_motorio_laterale',
				'$_motorio_inferiore',
				'$_motorio_superiore',
				'$_motorio_altro',
				'$_sensitiva_sede',
				'$_sensitiva_anteriore',
				'$_sensitiva_posteriore',
				'$_sensitiva_mediale',
				'$_sensitiva_intralesionale',
				'$_sensitiva_laterale',
				'$_sensitiva_inferiore',
				'$_sensitiva_superiore',
				'$_sensitiva_altro',
				'$_linguaggio_broca',
				'$_linguaggio_wermicke')";
       		 $rs = mysql_query($query);
	
		if ($rs == NULL)
			$error = 1;
	}


	public function retrive_by_id_paziente()
       {
		global $n_rm_bold;
	
		$_id_paziente=$this->getID_paziente();	
		
		$query = "SELECT id FROM rm_bold WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		$n_rm_bold=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_array($id, $n_rm_bold);
			$n_rm_bold = $n_rm_bold+1;
		}		
	}


	public function retrive_by_id($id)
       {
	
		$query = "SELECT id_paziente,data_inserimento,motorio_sede,motorio_anteriore,motorio_posteriore,motorio_mediale, motorio_intralesionale, motorio_laterale,motorio_inferiore,motorio_superiore,	motorio_altro,sensitiva_sede, sensitiva_anteriore,sensitiva_posteriore,	sensitiva_mediale,sensitiva_intralesionale,sensitiva_laterale,sensitiva_inferiore,sensitiva_superiore,sensitiva_altro,  linguaggio_broca,linguaggio_wernicke FROM rm_bold WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id_paziente,$data_inserimento,$motorio_sede,$motorio_anteriore,$motorio_posteriore,$motorio_mediale, $motorio_intralesionale, $motorio_laterale,$motorio_inferiore,$motorio_superiore,	$motorio_altro,$sensitiva_sede, $sensitiva_anteriore,$sensitiva_posteriore,	$sensitiva_mediale,$sensitiva_intralesionale,$sensitiva_laterale,$sensitiva_inferiore,$sensitiva_superiore,$sensitiva_altro,  $linguaggio_broca,$linguaggio_wernicke) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id_paziente);
			$this->setData_inserimento($data_inserimento);			
			$this->setMotorio_sede($motorio_sede);
			$this->setMotorio_anteriore($motorio_anteriore);
			$this->setMotorio_posteriore($motorio_posteriore);
			$this->setMotorio_mediale($motorio_mediale);
			$this->setMotorio_intralesionale($motorio_intralesionale);
			$this->setMotorio_laterale($motorio_laterale);
			$this->setMotorio_inferiore($motorio_inferiore);
			$this->setMotorio_superiore($motorio_superiore);
			$this->setMotorio_altro($motorio_altro);
			$this->setSensitiva_sede($sensitiva_sede);
			$this->setSensitiva_anteriore($sensitiva_anteriore);
			$this->setSensitiva_posteriore($sensitiva_posteriore);
			$this->setSensitiva_mediale($sensitiva_mediale);
			$this->setSensitiva_intralesionale($sensitiva_intralesionale);
			$this->setSensitiva_laterale($sensitiva_laterale);
			$this->setSensitiva_inferiore($sensitiva_inferiore);
			$this->setSensitiva_superiore($sensitiva_superiore);
			$this->setSensitiva_altro($sensitiva_altro);
			$this->setLinguaggio_broca($linguaggio_broca);
			$this->setLinguaggio_wernicke($linguaggio_wernicke);
		}		
	}

	public function delete($id)   // Insert the data of patient in the database:
    {
		$query = "DELETE FROM rm_bold WHERE id='$id'";
		$rs = mysql_query($query);	
	}
		
	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM rm_bold WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}

	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM rm_bold WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM rm_bold WHERE $nome_colonna LIKE '%$valore%'";
			
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

	public function setID_array($var, $n)
       {
		  $this->_id_array[$n] = $var;
        }

     public function setMotorio_sede($var)
    {
    	 $this->_motorio_sede=$var;
    }

    public function setMotorio_anteriore($var)
    {
    	 $this->_motorio_anteriore=$var;
    }

    public function setMotorio_posteriore($var)
    {
    	 $this->_motorio_posteriore=$var;
    }

    public function setMotorio_mediale($var)
    {
    	 $this->_motorio_mediale=$var;
    }
	
    public function setMotorio_intralesionale($var)
    {
    	 $this->_motorio_intralesionale=$var;
    }

    public function setMotorio_laterale($var)
    {
    	 $this->_motorio_laterale=$var;
    }

    public function setMotorio_inferiore($var)
    {
    	 $this->_motorio_inferiore=$var;
    }

    public function setMotorio_superiore($var)
    {
    	 $this->_motorio_superiore=$var;
    }

    public function setMotorio_altro($var)
    {
    	 $this->_motorio_altro=$var;
    }

	public function setSensitiva_sede($var)
    {
    	 $this->_sensitiva_sede=$var;
    }

    public function setSensitiva_anteriore($var)
    {
    	 $this->_sensitiva_anteriore=$var;
    }

    public function setSensitiva_posteriore($var)
    {
    	 $this->_sensitiva_posteriore=$var;
    }

    public function setSensitiva_mediale($var)
    {
    	 $this->_sensitiva_mediale=$var;
    }
	
    public function setSensitiva_intralesionale($var)
    {
    	 $this->_sensitiva_intralesionale=$var;
    }

    public function setSensitiva_laterale($var)
    {
    	 $this->_sensitiva_laterale=$var;
    }

    public function setSensitiva_inferiore($var)
    {
    	 $this->_sensitiva_inferiore=$var;
    }

    public function setSensitiva_superiore($var)
    {
    	 $this->_sensitiva_superiore=$var;
    }

    public function setSensitiva_altro($var)
    {
    	 $this->_sensitiva_altro=$var;
    }

    public function setLinguaggio_broca($var)
    {
    	 $this->_linguaggio_broca=$var;
    }

    public function setLinguaggio_wernicke($var)
    {
    	 $this->_linguaggio_wermicke=$var;
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

    public function getMotorio_sede()
    {
    	return $this->_motorio_sede;
    }

    public function getMotorio_anteriore()
    {
    	return $this->_motorio_anteriore;
    }

    public function getMotorio_posteriore()
    {
    	return $this->_motorio_posteriore;
    }

    public function getMotorio_mediale()
    {
    	return $this->_motorio_mediale;
    }
	
    public function getMotorio_intralesionale()
    {
    	return $this->_motorio_intralesionale;
    }

    public function getMotorio_laterale()
    {
    	return $this->_motorio_laterale;
    }

    public function getMotorio_inferiore()
    {
    	return $this->_motorio_inferiore;
    }

    public function getMotorio_superiore()
    {
    	return $this->_motorio_superiore;
    }

    public function getMotorio_altro()
    {
    	return $this->_motorio_altro;
    }

	public function getSensitiva_sede()
    {
    	return $this->_sensitiva_sede;
    }

    public function getSensitiva_anteriore()
    {
    	return $this->_sensitiva_anteriore;
    }

    public function getSensitiva_posteriore()
    {
    	return $this->_sensitiva_posteriore;
    }

    public function getSensitiva_mediale()
    {
    	return $this->_sensitiva_mediale;
    }
	
    public function getSensitiva_intralesionale()
    {
    	return $this->_sensitiva_intralesionale;
    }

    public function getSensitiva_laterale()
    {
    	return $this->_sensitiva_laterale;
    }

    public function getSensitiva_inferiore()
    {
    	return $this->_sensitiva_inferiore;
    }

    public function getSensitiva_superiore()
    {
    	return $this->_sensitiva_superiore;
    }

    public function getSensitiva_altro()
    {
    	return $this->_sensitiva_altro;
    }

    public function getLinguaggio_broca()
    {
    	return $this->_linguaggio_broca;
    }

    public function getLinguaggio_wermicke()
    {
    	return $this->_linguaggio_wermicke;
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