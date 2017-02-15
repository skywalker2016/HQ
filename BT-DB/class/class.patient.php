<?php
class patient
{
	private $_numero_pazienti;
	
	private $_id_patient;
	private $_id_patient_array;	
	private $_surname;   
	private $_name; 
	private $_sex; 
	private $_birthday;
	private $_address;     
	private $_telephone;     
	private $_note;   
	private $_reparto_provenienza;
	private $_data_decesso;

    function __construct($id, $surname, $name)
    {	
		global $error_surname;
		global $error_name;
	
        $this->_id_paziente = $id;
		
		// check surname and name:
		if (($surname == NULL) || ($surname == 'Devi inserire il cognome'))
			$error_surname = 1;
		else	
			$this->_surname = $surname;
 		
		if (($name == NULL) || ($name == 'Devi inserire il nome'))
			$error_name = 1;
		else	
			$this->_name = $name;       
    }

	public function insert()   // Insert the data of patient in the database:
    {
		global $error;
	
        $_surname=$this->getSurname();
        $_name=$this->getName();
        $_sex=$this->getSex();		
        $_birthday=$this->getBirthday();
        $_address=$this->getAddress();
        $_telephone=$this->getTelephone();
		$_note=$this->getNote();
		$_reparto_provenienza=$this->getReparto_provenienza();
		$_data_decesso=$this->getData_decesso();
		
		if ($_data_decesso == NULL)
			$_data_decesso = '00/00/0000';
		
        $_name = strtoupper($_name);
        $_surname = strtoupper($_surname);

		$_data_decesso=data_convert_for_mysql($_data_decesso);
		$_birthday=data_convert_for_mysql($_birthday);
		
		$query = "INSERT INTO patient
                (id, surname, name, date_birthday, sex, address, telephone, note, reparto_provenienza, data_decesso)
                VALUES
                (NULL, '$_surname', '$_name', '$_birthday', '$_sex', '$_address', '$_telephone', '$_note', '$_reparto_provenienza', '$_data_decesso')";
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
	
	public function retrive()   // Retrive the data from table: 'PATIENT':
    {
		// +++++++++ Retrive the information by surname, name, and birthday: ++++++++++++
		$_surname=$this->getSurname();
		$_name=$this->getName();
		$_birthday=$this->getBirthday();
		
        $_name = strtoupper($_name);
        $_surname = strtoupper($_surname);	
		
		$_birthday=data_convert_for_mysql($_birthday);
	
		$query = "SELECT id, sex, address, telephone, note, reparto_provenienza, data_decesso FROM patient WHERE surname = '$_surname' AND name = '$_name' AND date_birthday = '$_birthday'";
		$rs = mysql_query($query);
		while(list($id, $sex, $address, $telephone, $note, $reparto_provenienza, $data_decesso) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id);
			$this->setSex($sex);	
			$this->setAddress($address);
			$this->setTelephone($telephone);
			$this->setNote($note);			
			$this->setReparto_provenienza($reparto_provenienza);	
			$this->setData_decesso($data_decesso);	
		}
		// +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	}

	public function retrive_2($flag)   // Retrive the data from table: 'PATIENT':
    {
		if ($flag == 1)  // by surname
		{ 
			$_surname=$this->getSurname();
			$_surname = strtoupper($_surname);	
			$query = "SELECT id FROM patient WHERE surname LIKE '%$_surname%'";	
		}
		else if ($flag == 2) // by name
		{
			$_name=$this->getName();
			$_name = strtoupper($_name);
			$query = "SELECT id FROM patient WHERE name LIKE '%$_name%'";	
		}
		
		$rs = mysql_query($query);
		$n=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_paziente_array($id, $n);
			$n=$n+1;
		}
		$this->setNumero_pazienti($n);
	}	

	public function retrive_by_ID($id)   // Retrive the data from table: 'PATIENT':
    {
		$this->setID_paziente($id);
		$_id=$this->getID_paziente();
	
		$query = "SELECT surname, name, date_birthday, sex, address, telephone, note, reparto_provenienza, data_decesso FROM patient WHERE id = '$_id'";
		$rs = mysql_query($query);
		while(list($surname, $name, $date_birthday, $sex, $address, $telephone, $note, $reparto_provenienza, $data_decesso) = mysql_fetch_row($rs))
		{
			$date_birthday=data_convert_for_utente($date_birthday);
			$this->setSurname($surname);
			$this->setName($name);	
			$this->setData_nascita($date_birthday);
			$this->setSex($sex);
			$this->setAddress($address);
			$this->setTelephone($telephone);
			$this->setNote($note);
			$this->setReparto_provenienza($reparto_provenienza);
			$this->setData_decesso($data_decesso);				
		}
	}

	// Recupera ID dei pazienti usando solamente l'anno di nascita *********************************************************************
	 public function retrive_by_anno($flag, $data)   
   	 {		
		if ($flag == 1) // AAAA
			$query = "SELECT id FROM patient WHERE date_birthday LIKE '%$data%'";	
		else if ($flag == 2) // GG-MM-AAAA
			$query = "SELECT id FROM patient WHERE date_birthday = '$data'";

		$rs = mysql_query($query);
		$n_paz=0;
		while(list($id) = mysql_fetch_row($rs))
		{	
			$this->setID_paziente_array($id, $n_paz);
			$n_paz = $n_paz + 1;
		}
		$this->setNumero_pazienti($n_paz);
	}
	// ***********************************************************************************************************************************


	// Recupera ID dei pazienti usando il sesso, cognome, nome *********************************************************************************
	 public function retrive_by_generic_var($tipo, $var)   
   	 {		
		if ($tipo == 1)
			$query = "SELECT id FROM patient WHERE sex = '$var'";
		else if ($tipo == 2)
			$query = "SELECT id FROM patient WHERE surname LIKE '%$var%'";
		else if ($tipo == 3)
			$query = "SELECT id FROM patient WHERE name LIKE '%$var%'";

		$rs = mysql_query($query);
		$n_paz=0;
		while(list($id) = mysql_fetch_row($rs))
		{	
			$this->setID_paziente_array($id, $n_paz);
			$n_paz = $n_paz + 1;
		}
		$this->setNumero_pazienti($n_paz);
	}
	// *****************************************************************************************************************************

	public function delete_patient($id) // delete patient
       {
		$query = "DELETE FROM patient WHERE id='$id'";
		$rs = mysql_query($query);	
	}
	

	
	
	// Functions SET ******************************************************
    public function setData_nascita($birthday)
    {			
		  $this->_birthday = $birthday;
    }

 	public function setSurname($var)
    {
		  $this->_surname = $var;
    }	

 	public function setName($var)
    {
		  $this->_name = $var;
    }	
		
 	public function setSex($var)
    {
		  $this->_sex = $var;
    }	
	
 	public function setAddress($var)
    {
		  $this->_address = $var;
    }	
	
 	public function setTelephone($var)
    {
		  $this->_telephone = $var;
    }	
	
 	public function setID_paziente($var)
    {
		  $this->_id_patient = $var;
    }	

 	public function setNote($var)
    {
		  $this->_note = $var;
    }	
	
	 public function setReparto_provenienza($var)
    {
		  $this->_reparto_provenienza = $var;
    }

	 public function setData_decesso($var)
    {
		if ($var == NULL)
			$this->_data_decesso = '00/00/0000';
		else
		  	$this->_data_decesso = $var;
    }
	
	// Functions SET ARRAY ******************************************************
 	public function setNumero_pazienti($n)
    {
		  $this->_numero_pazienti = $n;
    }		
	
 	public function setID_paziente_array($var, $n)
    {
		  $this->_id_patient_array[$n] = $var;
    }	
	
	
 	// Functions GET ******************************************************
    public function getID_patient()
    {
    	return $this->_id_patient;
    }
    public function getSurname()
    {
     	return $this->_surname;
    }
    public function getName()
    {
        return $this->_name;
    }	   
    public function getSex()
    {
         return $this->_sex;
    }	    
    public function getBirthday()
    {
         return $this->_birthday;
    }	    
    public function getAddress()
    {
         return $this->_address;
    }	    
    public function getTelephone()
    {
         return $this->_telephone;
    }	
	public function getID_paziente()
    {
          return $this->_id_patient;
    }  
	public function getNote()
    {
          return $this->_note;
    }      
	public function getReparto_provenienza()
    {
          return $this->_reparto_provenienza;
    }  
	
     public function getNumero_pazienti()
    {
    	return $this->_numero_pazienti;
    }	

     public function getData_decesso()
    {
		if ($this->_data_decesso == '0000-00-00')
			return $this-> NULL;
		else
    		return $this->_data_decesso;
    }	
		
 	// Functions GET ARRAY ******************************************************	  
    public function getID_patient_array($i)
    {
    	return $this->_id_patient_array[$i];
    }	

	// *********
	public function __destruct()
    {}    
}
?>
