<?php
  /*****************************************************************************
   * @author    : Ferdjaoui Sahid
   * @email     : sahid@funraill.org
   * @blog	: http://sahid.funraill.org
   *
   * @license   : GNU GPL v3
   ****************************************************************************/

	/**
	 * Contacts Class
	 ************/


class Contacts
{
  public static $arr_type =  ['Gmail', 'MSN', 'Yahoo', 'Lycos', 'AOL'];

	public static function factory ($user, $pass, $type)
	{
	  if (in_array ($type, self::$arr_type))
	    {
	      $class = "{$type}Decorator";
	      return new $class ($user, $pass);
	    }
	  else throw new Exception ('Invalide type, utilisez : '.implode (", ", self::$arr_type));
	}
}


class LycosDecorator
{
	private $_instance;
	private $_user;
	private $_pass;

	public function __construct ($user, $pass) 
	{
		require ('libs/importLycos.class.php');
		$this->_instance = new grabLycos ($user, $pass);
		$this->_user = $user;
		$this->_pass = $pass;
	}

	public function getContacts ()
	{	
		$result =  [];
		if (!is_object ($this->_instance))
			throw new Exception ("Aucune instance");
		$contacts = (array) @$this->_instance->getContactList ();
		$i = 0;
		foreach ($contacts as $name => $email)
			{
				$result[$i]['name'] = $name;
				$result[$i]['email'] = $email;
				$i++;
			}
		return $result;
	}
}


class AOLDecorator
{
	private $_instance;
	private $_user;
	private $_pass;

	public function __construct ($user, $pass) 
	{
		require ('libs/importAol.class.php');
		$this->_instance = new grabAol ($user, $pass);
		$this->_user = $user;
		$this->_pass = $pass;
	}

	public function getContacts ()
	{	
		$result =  [];
		if (!is_object ($this->_instance))
			throw new Exception ("Aucune instance");
		$contacts = (array) @$this->_instance->getContactList ();
		$i = 0;
		foreach ($contacts as $name => $email)
			{
				$result[$i]['name'] = $name;
				$result[$i]['email'] = $email;
				$i++;
			}
		return $result;
	}
}



class MSNDecorator
{
	private $_instance;

	public function __construct (private $_user, private $_pass) 
	{
		require ('libs/importMsn.class.php');
		$this->_instance = new msn;
	}

	public function getContacts ()
	{	
		$result =  [];
		if (!is_object ($this->_instance))
			throw new Exception ("Aucune instance");
		$contacts = (array) @$this->_instance->qGrab ($this->_user, $this->_pass);
		$i = 0;
		foreach ($contacts as $contact)
			{
				$result[$i]['name'] = $contact['1'];
				$result[$i]['email'] = $contact['0'];
				$i++;
			}
		return $result;
	}
}

class YahooDecorator
{
	private $_instance;
	private $_user;
	private $_pass;

	public function __construct ($user, $pass) 
	{
		require ('libs/importYahoo.class.php');
		$this->_instance = new yahooGrabber ($user, $pass);
		$this->_user = $user;
		$this->_pass = $pass;
	}

	public function getContacts ()
	{	
		$result =  [];
		if (!is_object ($this->_instance))
			throw new Exception ("Aucune instance Yahoo Grabber");
		$contacts = (array) @$this->_instance->grabYahoo ();
		$i = 0;
		foreach ($contacts as $name => $email)
			{
				$result[$i]['name'] = $name;
				$result[$i]['email'] = $email;
				$i++;
			}
		return $result;
	}
}

class GmailDecorator
{
	private $_instance;

	public function __construct (private $_user, private $_pass) 
	{
		require ('libs/importGmail.class.php');
		$this->_instance = new GMailer;
	}

	public function getContacts ()
	{	
		$result =  [];
		if (!is_object ($this->_instance))
			throw new Exception ("Aucune instance GMailer");
		$this->_instance->setLoginInfo ($this->_user, $this->_pass, "+1GMT");
		if ($this->_instance->connect ())
			{
				$this->_instance->fetchBox (GM_CONTACT, 'all', '');
				$snapshot = $this->_instance->getSnapshot (GM_CONTACT);
				$this->_instance->disconnect ();
				$i = 0;
				if (isset ($snapshot->contacts))
					foreach ($snapshot->contacts as $contact)
						{
							$result[$i]['name'] = $contact['name'];
							$result[$i]['email'] = $contact['email'];
							$i++;
						}
				return $result;
			}
		else
			throw new Exception ('Impossible de se connecter');
	}
}
