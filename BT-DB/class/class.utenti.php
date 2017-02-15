<?php
class utenti
{
	private $_id;
	private $_username;
	private $_password;
	private $_permission;
	private $_id_array;	
	
	function __construct($username, $password, $permission)
	{		
		$this->_username = $username;
		$this->_password = $password;
		$this->_permission = $permission;
	}
	

	public function insert()
	{
		$_username=$this->getUsername();
		$_password=$this->getPassword();
		$_permission=$this->getPermission();		

		$query = "INSERT INTO user
		(id, username, password, permission)
		VALUES
		(NULL, '$_username', '$_password', '$_permission')";
		$rs = mysql_query($query);
	}


	public function retrive($flag)  
    	{	
		global $n_utenti;
		
		if ($flag == 1) // recupera solo id per il conteggio degli utenti
			$query = "SELECT id, username, password, permission FROM user";
		else if ($flag == 2) // recupera tutti i dati
		{
			$_id=$this->getID();
			$query = "SELECT id, username, password, permission FROM user WHERE id='$_id' ORDER BY permission ASC";		
		}
		
		$rs = mysql_query($query);
		
		if ($flag == 1)
			$n_utenti=0;
		
		while(list($id, $username, $password, $permission) = mysql_fetch_row($rs))
		{
			if ($flag == 1)
				$this->setID_array($id, $n_utenti);	
			
			$this->setID($id);
			$this->setUsername($username);
			$this->setPassword($password);
			$this->setPermission($permission);
			
			if ($flag == 1)
				$n_utenti = $n_utenti + 1;
		}
	}
	
	public function delete($id)
    {
		$query = "DELETE FROM user WHERE id='$id'";
		$rs = mysql_query($query);	
	}	
	
	
	// Functions SET ******************************************************
	public function setID_array($id, $n)
	{
		$this->_id_array[$n]= $id;
	}	
		
    public function setID($var)
    {			
		  $this->_id = $var;
    }
	
    public function setUsername($var)
    {			
	global $error_1;

	if ($var == NULL)
		$error_1 = 1;
	else
		 $this->_username = $var;
    }	
	
    public function setPassword($var)
    {			
	global $error_1;

	if ($var == NULL)
		$error_1 = 1;
	else
		 $this->_password = $var;
    }	
	
    public function setPermission($var)
    {			
		  $this->_permission = $var;
    }	
	
	// Functions GET ******************************************************
	 public function getID_array($n)
    {
    	return $this->_id_array[$n];
    }
	
    public function getID()
    {
    	return $this->_id;
    }
	
    public function getUsername()
    {
    	return $this->_username;
    }		
		
    public function getPassword()
    {
    	return $this->_password;
    }		
		
    public function getPermission()
    {
    	return $this->_permission;
    }		
	
	// *********
	public function __destruct()
    {}  		
}
?>	