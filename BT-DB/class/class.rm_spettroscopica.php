<?php
class rm_spettroscopica
{
	private $_id_paziente;
	private $_naa_ridotto;
	private $_valore_naa_cr;	
	private $_cho_cr;
	private $_lipidi_lattati;
	private $_mioinositolo;
	private $_tipo_spettro;
	private $_te;
	private $_data_inserimnento;
	private $_id_array;
	
	function __construct($id_paziente, $naa_ridotto, $valore_naa_cr, $cho_cr, $lipidi_lattati, $mioinositolo, $tipo_spettro, $te)
       {	
		$this->_id_paziente = $id_paziente;
		$this->_naa_ridotto = $naa_ridotto;		

		if ($valore_naa_cr == NULL)
			$this->_valore_naa_cr = -1000;
		else
			$this->_valore_naa_cr = $valore_naa_cr;
		
		if ($cho_cr == NULL)
			$this->_cho_cr = -1000;
		else	
			$this->_cho_cr = $cho_cr;
			
		$this->_lipidi_lattati = $lipidi_lattati;
		$this->_mioinositolo = $mioinositolo;	
		$this->_tipo_spettro = $tipo_spettro;	
		$this->_te = $te;						
       }

	public function insert()   // Insert the data of patient in the database:
       {
		global $error;
	
		$_id_paziente=$this->getID_paziente();
		$_naa_ridotto=$this->getNaa_ridotto();
		$_valore_naa_cr=$this->getValore_naa_cr();
		$_cho_cr=$this->getCho_cr();
		$_lipidi_lattati=$this->getLipidi_lattati();
		$_mioinositolo=$this->getMioinositolo();
		$_tipo_spettro=$this->getTipo_spettro();
		$_data_inserimento =$this->getData_inserimento();
		$_te =$this->getTe();	

		$query = "INSERT INTO rm_spettroscopica
                (id, id_paziente, naa_ridotto, valore_naa_cr, cho_cr, lipidi_lattati, mioinositolo, tipo_spettro, te, data_inserimento)
                VALUES
                (NULL, '$_id_paziente', '$_naa_ridotto', '$_valore_naa_cr', '$_cho_cr', '$_lipidi_lattati', '$_mioinositolo', '$_tipo_spettro', '$_te', '$_data_inserimento')";
		$rs = mysql_query($query);
	
		if ($rs == NULL)
		$error = 1;
	}


	public function retrive_by_id_paziente()
	{
		global $n_rm_spettroscopica;
	
		$_id_paziente=$this->getID_paziente();	
		
		$query = "SELECT id FROM rm_spettroscopica WHERE id_paziente = '$_id_paziente'";
		$rs = mysql_query($query);
		$n_rm_spettroscopica=0;
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_array($id, $n_rm_spettroscopica);
			$n_rm_spettroscopica = $n_rm_spettroscopica+1;
		}		
	}

	public function retrive_by_id($id)
        {
		$query = "SELECT id_paziente, naa_ridotto, valore_naa_cr, cho_cr, lipidi_lattati, mioinositolo, tipo_spettro, te, data_inserimento FROM rm_spettroscopica WHERE id = '$id'";
		$rs = mysql_query($query);
		while(list($id_paziente, $naa_ridotto, $valore_naa_cr, $cho_cr, $lipidi_lattati, $mioinositolo, $tipo_spettro, $te, $data_inserimento) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id_paziente);
			$this->setNaa_ridotto($naa_ridotto);
			$this->setValore_naa_cr($valore_naa_cr);
			$this->setCho_cr($cho_cr);
			$this->setLipidi_lattati($lipidi_lattati);
			$this->setMioinositolo($mioinositolo);
			$this->setTipo_spettro($tipo_spettro);
			$this->setTe($te);
			$this->setData_inserimento($data_inserimento);
		}		
	 }	

	public function delete($id)   // Insert the data of patient in the database:
    {
		$query = "DELETE FROM rm_spettroscopica WHERE id='$id'";
		$rs = mysql_query($query);	
	}
	
	public function delete_patient($id) // delete patient
    {
		$query = "DELETE FROM rm_spettroscopica WHERE id_paziente='$id'";
		$rs = mysql_query($query);	
	}

	public function retrive_motore_ricerca($flag, $nome_colonna, $operazione, $valore)
	{
		if ($flag == 1)
			$query = "SELECT id_paziente FROM rm_spettroscopica WHERE $nome_colonna $operazione '$valore'";
		if ($flag == 2)
			$query = "SELECT id_paziente FROM rm_spettroscopica WHERE $nome_colonna LIKE '%$valore%'";
			
		$rs = mysql_query($query);
		while(list($id) = mysql_fetch_row($rs))
		{
			$this->setID_paziente($id);			
		}
	}
			
	// Function SET *******************************************************

	public function setID_paziente($var)
   	{
		$this->_id_paziente = $var;
    	}

	public function setNaa_ridotto($var)
   	{
		$this->_naa_ridotto = $var;
    	}

	public function setValore_naa_cr($var)
   	{
		$this->_valore_naa_cr = $var;
    	}

	public function setCho_cr($var)
   	{
		$this->_cho_cr = $var;
    	}

	public function setLipidi_lattati($var)
   	{
		$this->_lipidi_lattati = $var;
    	}

	public function setMioinositolo($var)
   	{
		$this->_mioinositolo = $var;
    	}

	public function setTipo_spettro($var)
   	{
		$this->_tipo_spettro = $var;
    	}

	public function setTe($var)
   	{
		$this->_te = $var;
    	}

	public function setData_inserimento($var)
   	{
		$this->_data_inserimento = $var;
    	}

	public function setID_array($var, $n)
   	 {
		  $this->_id_array[$n] = $var;
   	 }



	// Functions GET ******************************************************
	public function getID_paziente()
	{
		return $this->_id_paziente;
	}
	
	public function getNaa_ridotto()
	{
		return $this->_naa_ridotto;
	}
	
	public function getValore_naa_cr()
	{
		return $this->_valore_naa_cr;
	}
	
	public function getCho_cr()
	{
		return $this->_cho_cr;
	}
	
	public function getLipidi_lattati()
	{
		return $this->_lipidi_lattati;
	}
	
	public function getMioinositolo()
	{
		return $this->_mioinositolo;
	}
	
	public function getTipo_spettro()
	{
		return $this->_tipo_spettro;
	}
	
	public function getTe()
	{
		return $this->_te;
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