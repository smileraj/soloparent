<?php
/*This plugin import Gmail contacts
 *You can send normal email   
 */
$_pluginInfo=[
	'name'=>'GMail',
	'version'=>'1.4.9',
	'description'=>"Get the contacts from a GMail account",
	'base_version'=>'1.8.4',
	'type'=>'email',
	'check_url'=>'http://google.com',
	'requirement'=>'email',
	'allowed_domains'=>false,
	'detected_domains'=>['/(gmail.com)/i','/(googlemail.com)/i'],
	'imported_details'=>['first_name','email_1','email_2','email_3','organization','phone_mobile','phone_home','fax','pager','address_home','address_work'],
	];
/**
 * GMail Plugin
 * 
 * Imports user's contacts from GMail's AddressBook
 * 
 * @author OpenInviter
 * @version 1.4.1
 */
class gmail extends openinviter_base
	{
	private $login_ok=false;
	public $showContacts=true;
	public $internalError=false;
	
	public $debug_array=[
	  'login_post'=>'Auth=',
	  'contact_xml'=>'xml'
	];
	
	/**
	 * Login function
	 * 
	 * Makes all the necessary requests to authenticate
	 * the current user to the server.
	 * 
	 * @param string $user The current user.
	 * @param string $pass The password for the current user.
	 * @return bool TRUE if the current user was authenticated successfully, FALSE otherwise.
	 */
	public function login($user,$pass)
		{
		$this->resetDebugger();
		$this->service='gmail';
		$this->service_user=$user;
		$this->service_password=$pass;
		if (!$this->init()) return false;
			
		$post_elements=['accountType'=>'HOSTED_OR_GOOGLE','Email'=>$user,'Passwd'=>$pass,'service'=>'cp','source'=>'OpenInviter-OpenInviter-'.$this->base_version];
	    $res=$this->post("https://www.google.com/accounts/ClientLogin",$post_elements,true);
	    if ($this->checkResponse("login_post",$res))
			$this->updateDebugBuffer('login_post',"https://www.google.com/accounts/ClientLogin",'POST',true,$post_elements);
		else
			{
			$this->updateDebugBuffer('login_post',"https://www.google.com/accounts/ClientLogin",'POST',false,$post_elements);
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
	    
		$auth=substr((string) $res,strpos((string) $res,'Auth=')+strlen('Auth='));
		
		$this->login_ok=$auth;
		return true;
		}

	/**
	 * Get the current user's contacts
	 * 
	 * Makes all the necesarry requests to import
	 * the current user's contacts
	 * 
	 * @return mixed The array if contacts if importing was successful, FALSE otherwise.
	 */	
	public function getMyContacts()
		{
		if ($this->login_ok===false)
			{
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
		else $auth=$this->login_ok; 
		$res=$this->get("http://www.google.com/m8/feeds/contacts/default/full?max-results=10000",true,false,true,false,["Authorization"=>"GoogleLogin auth={$auth}"]);
		if ($this->checkResponse("contact_xml",$res))
			$this->updateDebugBuffer('contact_xml','http://www.google.com/m8/feeds/contacts/default/full?max-results=10000','GET');
		else
			{
			$this->updateDebugBuffer('contact_xml','http://www.google.com/m8/feeds/contacts/default/full?max-results=10000','GET',false);
			$this->debugRequest();
			$this->stopPlugin();
			return false;
			}
		
		$contacts=[];
		$doc=new DOMDocument();libxml_use_internal_errors(true);if (!empty($res)) $doc->loadHTML('<?xml encoding="UTF-8">'.$res);libxml_use_internal_errors(false);		
		$xpath=new DOMXPath($doc);$query="//entry";$data=$xpath->query($query);
		foreach ($data as $node) 
			{
			$entry_nodes=$node->childNodes;
			$tempArray=[];	
			foreach($entry_nodes as $child)
				{ 
				$domNodesName=$child->nodeName;
				switch($domNodesName)
					{
					case 'title' : { $tempArray['first_name']=$child->nodeValue; } break;
					case 'organization': { $tempArray['organization']=$child->nodeValue; } break;
					case 'email' : 
						{ 
						if (str_contains($child->getAttribute('rel'),'home'))
							$tempArray['email_1']=$child->getAttribute('address');
						elseif(str_contains($child->getAttribute('rel'),'work'))  	
							$tempArray['email_2']=$child->getAttribute('address');
						elseif(str_contains($child->getAttribute('rel'),'other'))  	
							$tempArray['email_3']=$child->getAttribute('address');
						} break;
					case 'phonenumber' :
						{
						if (str_contains($child->getAttribute('rel'),'mobile'))
							$tempArray['phone_mobile']=$child->nodeValue;
						elseif(str_contains($child->getAttribute('rel'),'home'))  	
							$tempArray['phone_home']=$child->nodeValue;	
						elseif(str_contains($child->getAttribute('rel'),'work_fax'))  	
							$tempArray['fax_work']=$child->nodeValue;
						elseif(str_contains($child->getAttribute('rel'),'pager'))  	
							$tempArray['pager']=$child->nodeValue;
						} break;
					case 'postaladdress' :
						{
						if (str_contains($child->getAttribute('rel'),'home'))
							$tempArray['address_home']=$child->nodeValue;
						elseif(str_contains($child->getAttribute('rel'),'work'))  	
							$tempArray['address_work']=$child->nodeValue;
						} break;	
					}
				}
			if (!empty($tempArray['email_1']))$contacts[$tempArray['email_1']]=$tempArray;
			if(!empty($tempArray['email_2'])) $contacts[$tempArray['email_2']]=$tempArray;
			if(!empty($tempArray['email_3'])) $contacts[$tempArray['email_3']]=$tempArray;
			}
		foreach ($contacts as $email=>$name) if (!$this->isEmail($email)) unset($contacts[$email]);
		return $this->returnContacts($contacts);
		}
	
	/**
	 * Terminate session
	 * 
	 * Terminates the current user's session,
	 * debugs the request and reset's the internal 
	 * debudder.
	 * 
	 * @return bool TRUE if the session was terminated successfully, FALSE otherwise.
	 */	
	public function logout()
		{
		if (!$this->checkSession()) return false;
		$this->debugRequest();
		$this->resetDebugger();
		$this->stopPlugin();
		return true;
		}
	}
?>