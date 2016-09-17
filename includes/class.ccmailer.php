<?php
/****************************************************************************************************
 * file: class.ccmailer.php
 * author: chris w.
 * lastrev: 12/16/2010
 * desc: base class for webmailing
 ***************************************************************************************************/



/****************************************************************************************************
 * class ccmailer
 ***************************************************************************************************/
class ccmailer
{
	var $timezone = 'America/Los_Angeles';
	var $to = false;
	var $subject = false;
	var $message = false;
	var $headers = false;
	var $extra_params = false;
	var $newline_char = "\r\n";
	var $test_mode = false;			//if true, echo contents instead of actually sending mail.
	
	private $allow_multiple_to = true;
	private $allow_cc = false;
	var $un_htmlentities = false;
	
	/***************************************************************************************************
  * __construct()
  ***************************************************************************************************/
	function __construct()
	{
		
		return true;
	}
	
	
	/***************************************************************************************************
  * set_allow_multiple_to() - determine whether multiple recipients are allowed
  ***************************************************************************************************/
	function set_allow_multiple_to($allow=false)
	{
		$this->allow_multiple_to = $allow;
		return true;
	}
	
	
	/***************************************************************************************************
  * set_allow_cc() - determine whether cc/bcc is allowed at all
  ***************************************************************************************************/
	function set_allow_cc($allow=false)
	{
		$this->allow_cc = $allow;
		return true;
	}
	
	
	/***************************************************************************************************
  * make_safe() - generally make mail injection safe
  ***************************************************************************************************/
	function make_safe()
	{
		if($this->allow_multiple_to == false)
		{
			$this->to = str_replace(",", "", $this->to);
		}
		$this->to = trim($this->to);
		$this->strip_all_newlines();
		if($this->allow_cc == false)
		{
			$this->strip_all_cc();
		}
		return true;
	}
	
	
	/***************************************************************************************************
  * strip_all_newlines() - strip all newline characters from all injectable fields
  ***************************************************************************************************/
	function strip_all_newlines()
	{
		$this->to = $this->strip_newlines($this->to);
		$this->subject = $this->strip_newlines($this->subject);
		$this->headers = $this->strip_newlines($this->headers);
		return true;
	}
	
	
	/***************************************************************************************************
  * strip_all_cc() - strip all cc/bcc characters from all injectable fields
  ***************************************************************************************************/
	function strip_all_cc()
	{
		$this->to = $this->strip_cc($this->to);
		$this->subject = $this->strip_cc($this->subject);
		$this->headers = $this->strip_cc($this->headers);
		return true;
	}
	
	
	/***************************************************************************************************
  * strip_newlines() - strip newlines from text (use for injectable fields)
  ***************************************************************************************************/
	function strip_newlines($text)
	{
		if($text === false)
		{
			return false;
		}
		else
		{
			$stripped = str_ireplace("\r", "", $text);
			$stripped = str_ireplace("\n", "", $stripped);
			$stripped = trim($stripped);
			return $stripped;
		}
	}
	
	
	/***************************************************************************************************
  * strip_cc() - strip CC: and BCC:, ideally always do this and only use private cclist
  ***************************************************************************************************/
	function strip_cc($text)
	{
		if($text === false)
		{
			return false;
		}
		else
		{
			$stripped = str_ireplace("bcc:", "", $text);
			$stripped = str_ireplace("cc:", "", $text);
			$stripped = trim($stripped);
			return $stripped;
		}
	}
	
	
	/***************************************************************************************************
  * send() - send mail. remove message tab chars by default
  ***************************************************************************************************/
	function send($do_untab_message=true, $mute_errors=true)
	{
		if($this->nonblank())
		{
			if($do_untab_message)
			{
				$this->message = str_ireplace("\t", "", $this->message);
			}
			if($this->un_htmlentities)
			{
				$this->message = html_entity_decode($this->message);
			}
			if($this->test_mode)
			{
				$this->message = str_ireplace("\r\n", '<br />', $this->message);
				echo  'To: ' . $this->to . '<br />' .
							'Subject: ' . $this->subject . '<br />' .
							'-MESSAGE-' . '<br />' .
							$this->message . '<br />' .
							'-END-';
				die();
				return true;
			}
			elseif($mute_errors)
			{
				@mail($this->to, $this->subject, $this->message);
				return true;
			}
			else
			{
				$result = mail($this->to, $this->subject, $this->message);
				return $result;
			}
		}
		else
		{
			return false;
		}
	}
	
	
	/***************************************************************************************************
  * nonblank() - ensure that to/subject/message are not blank
  ***************************************************************************************************/
	function nonblank()
	{
		if(($this->to === false) || ($this->subject === false) || ($this->message === false))
		{
			return false;
		}
		$this->to = trim($this->to);
		$this->subject = trim($this->subject);
		$this->message = trim($this->message);
		if(($this->to === "") || ($this->subject === "") || ($this->message === ""))
		{
			return false;
		}
		return true;
	}
	
	
	/***************************************************************************************************
  * append_field() - append a postfield name/value pair to message, on a newline
  ***************************************************************************************************/
	function append_field($name="", $value="", $value_newline=false, $pre_newline=true)
	{
		$name = trim($name);
		if((strpos($name, ":")) === false)
		{
			$name .= ":";
		}
		$name .= " ";
		$this->append_message($name, $pre_newline);
		$value = trim($value);
		$this->append_message($value, $value_newline);
		return true;
	}
	
	
	/***************************************************************************************************
  * append_message() - append text to message content
  ***************************************************************************************************/
	function append_message($text, $pre_newline=false)
	{
		if($pre_newline)
		{
			$this->message .= $this->newline_char;
		}
		$this->message .= $text;
		return true;
	}
	
	
	/***************************************************************************************************
  * print_timestamp() - print formatted timestamp like 'h:mm on MM/DD/YYYY'
  ***************************************************************************************************/
	function print_timestamp()
	{
		date_default_timezone_set($this->timezone);
		$formatted = date('m/d/Y', time());
		$formatted .= ' @ ';
		$formatted .= date('g:ia', time());
		return $formatted;
	}
	
	
	
}