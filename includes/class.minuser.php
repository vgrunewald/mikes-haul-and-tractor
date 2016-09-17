<?php
/**********************************************************************************************************************
 * file: class.minuser.php
 * author: [WDS]chris
 * lastrev: 06/26/2011
 * desc: very basic user class
 *********************************************************************************************************************/
class minuser
{
	var $logged_in = false;
	
	
	/*********************************************************************************************************************
	* __construct()
  *********************************************************************************************************************/
	function __construct($do_sync=true)
	{
		if($do_sync)
		{
			$this->sync_me();
		}
	}
	
	
	/*********************************************************************************************************************
	* sync_me() - copy session vars to class vars
  *********************************************************************************************************************/
	function sync_me()
	{
		$this->logged_in = $this->sessif('logged_in');
	}
	
	
	/*********************************************************************************************************************
	* sessif() - return SESSION var or false if undefined, optionally unset (i.e. for form repost / other one-time uses)
	*********************************************************************************************************************/
	function sessif($field, $destroy=false)
	{
		if(isset($_SESSION["$field"]))
		{
			$sessed = $_SESSION["$field"];
			if($destroy)
			{
				unset($_SESSION["$field"]);
			}
		}
		else
		{
			$sessed = false;
		}
		return $sessed;
	}
	
	
	/*********************************************************************************************************************
	* set_message() - add user message
  *********************************************************************************************************************/
	function set_message($message, $type='notice')
	{
		$usermessages = $this->sessif('usermessages');
		if(!(is_array($usermessages)))
		{
			$usermessages = array();
		}
		$temp = array('message'	=>	$message,
									'type'		=>	$type);
		array_push($usermessages, $temp);
		$_SESSION['usermessages'] = $usermessages;
	}
	
	
	/*********************************************************************************************************************
	* dump_message_queue() - dump all user messages and clear queue
  *********************************************************************************************************************/
	function dump_message_queue($fixed_container=false)
	{
		$usermessages = $this->sessif('usermessages', true);
		if(is_array($usermessages))
		{
			$toecho = '<div class="umessage">';
			foreach($usermessages as $thismessage)
			{
				switch($thismessage['type'])
				{
					case 'error':
						$umsg_class = 'umsg_error';
						break;
					case 'result':
						$umsg_class = 'umsg_result';
						break;
					case 'notice':
					default:
						$umsg_class = 'umsg_notice';
						break;
				}
				$toecho .= '<div class="' . $umsg_class . '">' . $thismessage['message'] . '</div>';
			}
			$toecho .= '</div>';
			if($fixed_container)
			{
				$toecho = '<div class="umessage_fixed">' . $toecho . '</div>';
			}
			echo $toecho;
		}
	}
	

}
?>