<?php
class rm_morfologica
{
	private $_id_paziente;
	private $_extrassiale;
	private $_intrassiale;
	private $_t2_flair;	
	private $_flair_3d;	
	private $_volume_neo;	
	private $_dwi;
	private $_dwi_ristretta;	
	private $_adc;	
	private $_adc_ridotto;	
	private $_valore_adc;	
	private $_ce;
	private $_tipo_ce;	
	private $_id_array;
	private $_data_inserimento;
		

	function __construct($id_paziente, $extrassiale, $intrassiale, $t2_flair, $flair_3d, $volume_neo, $dwi, $dwi_ristretta, $adc, $adc_ridotto, $valore_adc, $ce, $tipo_ce)
    {	
		$this->_id_paziente = $id_paziente;		
      		 $this->_extrassiale = $extrassiale;
		$this->_intrassiale = $intrassiale;
		$this->_t2_flair = $t2_flair;
		$this->_flair_3d = $flair_3d;
		
		if ($volume_neo == NULL)
			$this->_volume_neo = -1000;
		else
			$this->_volume_neo = $volume_neo;
		
		$this->_dwi = $dwi;
		$this->_dwi_ristretta = $dwi_ristretta;
		$this->_adc = $adc;
		$this->_adc_ridotto = $adc_ridotto;
		
		if ($valore_adc == NULL)
			$this->_valore_adc = -1000;
		else	
			$this->_valore_adc = $valore_adc;
			
		$this->_ce = $ce;
		$this->_tipo_ce = $tipo_ce;		
    }


	public function insert()   // Insert the data of patient in the database:
    {
		global $error;
	
		$_id_paziente=$this->getID_paziente();
		$_extrassiale=$this->getExtrassiale();
		$_intrassiale=$this->getIntrassiale();
		$_t2_flair=$this->getT2_flair();
		$_flair_3d=$this->getFlair_3d();
		$_volume_neo=$this->getVolume_neo();
		$_dwi=$this->getDwi();
		$_dwi_ristretta=$this->getDwi_ristretta();
		$_adc=$this->getAdc();
		$_adc_ridotto=$this->getAdc_ridotto();
		$_valore_adc=$this->getValore_adc_ridotto();
		$_ce=$this->getCe();
		$_tipo_ce=$this->getTipo_ce();
		$_data_inserimento=$this->getData_inserimento();

	
		$query = "INSERT INTO rm_morfologica
                (id, id_paziente, extrassiale, intrassiale, t2_flair, flair_3d, volume_neo, dwi, dwi_ristretta, adc, tipo_adc, valore_adc, ce, tipo_ce, data_inserimento)
                VALUES
                (NULL, '$_id_paziente', '$_extrassiale', '$_intrassiale', '$_t2_flair', '$_flair_3d', '$_volume_neo', '$_dwi', '$_dwi_ristretta', '$_adc', '$_adc_ridotto', '$_valore_adc', '$_ce', '$_tipo_ce', '$_data_inserimento')";
        $rs = mysql_query($query);
		if ($rs == NULL)
			$error = 1;
	}
	
	
	public function retrive_by_id_paziente()
    {
		global $n_rm_morfologica;
	
		$_id_paziente=$this->getID_paziente();	
		
		$query = "SELECT id FROM rm_morfologica WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		$n_rm_morfologica=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_array($id, $n_rm_morfologica);
			$n_rm_morfologica = $n_rm_morfologica+1;
		}		
	}
	
	public function retrive_by_id($id)
    {
	
		$query = "SELECT id_paziente, extrassiale, intrassiale, t2_flair, flair_3d,	volume_neo,	dwi, dwi_ristretta, adc, tipo_adc, valore_adc, ce, tipo_ce, data_inserimento FROM rm_morfologica WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id_paziente, $extrassiale, $intrassiale, $t2_flair, $flair_3d,	$volume_neo, $dwi, $dwi_ristretta, $adc, $tipo_adc, $valore_adc, $ce, $tipo_ce, $data_inserimento) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id_paziente);
			$this->setExtrassiale($extrassiale);
			$this->setIntrassiale($intrassiale);
			$this->setT2_flair($t2_flair);
			$this->setFlair_3d($flair_3d);
			$this->setVolume_neo($volume_neo);
			$this->setDwi($dwi);
			$this->setDwi_ristretta($dwi_ristretta);
			$this->setAdc($adc);
			$this->setTipo_adc($tipo_adc);
			$this->setValore_adc($valore_adc);
			$this->setCe($ce);
			$this->setTipo_ce($tipo_ce);
			$this->setData_inserimento($data_inserimento);
		}		
	}

	public function delete($id)   // Insert the data of patient in the database:
    {
		$query = "DELETE FROM rm_morfologica WHERE id='$id'";
		$rs = mysql_query($query);	
	}
	
	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM rm_morfologica WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}

	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM rm_morfologica WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM rm_morfologica WHERE $nome_colonna LIKE '%$valore%'";
			
		$rs = mysql_query($query);
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id);			
		}
	}
			
	// Functions SET ******************************************************
	public function setID_paziente($var)
    {
		  $this->_id_paziente = $var;
    }

	public function setExtrassiale($var)
    {
		  $this->_extrassiale = $var;
    }	
	public function setIntrassiale($var)
    {
		  $this->_intrassiale = $var;
    }	
	public function setT2_flair($var)
    {
		  $this->_t2_flair = $var;
    }
	public function setFlair_3d($var)
    {
		  $this->_flair_3d = $var;
    }
	public function setVolume_neo($var)
    {
		  $this->_volume_neo = $var;
    }
	public function setDwi($var)
    {
		  $this->_dwi = $var;
    }
	public function setDwi_ristretta($var)
    {
		  $this->_dwi_ristretta = $var;
    }
	public function setAdc($var)
    {
		  $this->_adc = $var;
    }	
	public function setTipo_adc($var)
    {
		  $this->_tipo_adc= $var;
    }	
	public function setValore_adc($var)
    {
		  $this->_valore_adc= $var;
    }	
	public function setCe($var)
    {
		  $this->_ce= $var;
    }		
	public function setTipo_ce($var)
    {
		  $this->_tipo_ce= $var;
    }		
	public function setData_inserimento($var)
    {
		  $this->_data_inserimento= $var;
    }		
	
	public function setID_array($var, $n_esame_tc)
    {
		  $this->_id_array[$n_esame_tc] = $var;
    }
	

	// Functions GET ******************************************************
	public function getID_array($n)
    {
    	return $this->_id_array[$n];
    }
	
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

    public function getT2_flair()
    {
    	return $this->_t2_flair;
    }

    public function getFlair_3d()
    {
    	return $this->_flair_3d;
    }

    public function getVolume_neo()
    {
    	return $this->_volume_neo;
    }

    public function getDwi()
    {
    	return $this->_dwi;
    }

    public function getDwi_ristretta()
    {
    	return $this->_dwi_ristretta;
    }

    public function getAdc()
    {
    	return $this->_adc;
    }

    public function getAdc_ridotto()
    {
    	return $this->_tipo_adc;
    }

    public function getValore_adc_ridotto()
    {
    	return $this->_valore_adc;
    }

    public function getCe()
    {
    	return $this->_ce;
    }
	
    public function getTipo_ce()
    {
    	return $this->_tipo_ce;
    }

    public function getData_inserimento()
    {
    	return $this->_data_inserimento;
    }
		
	// *********
	public function __destruct()
    {}   
}
?>