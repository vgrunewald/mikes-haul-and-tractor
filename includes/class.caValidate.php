<?php
/****************************************************************************************************
 * file: class.caValidate.php
 * author: chris w., webdevseattle
 * lastrev: 01/28/2012
 * desc: base class for retrieving superglobals, validating, and reposting for class.caform
 * deps: config.regex.php
 ***************************************************************************************************/



/****************************************************************************************************
 * class caValidate
 ***************************************************************************************************/
class caValidate
{
	var $stripslashes = true;
	var $fail_repost = false;
	var $failed_fields = array();
	var $passed_fields = array();
	var $passed_values = array();
	var $repost_return_id = false;	//if the form has a return id, get it and store in session
	
	var $default_empty_superglobal = '';			//if a GET or POST var is empty, return this as default
	
	var $default_lazy_minlength = 1;
	var $default_lazy_maxlength = 100;
	
	private $regexdef;
	
	private $longtext_maxlength = 3000;
	
	private $checkbox_list = array();
	
	
	/***************************************************************************************************
  * __construct()
  ***************************************************************************************************/
	function __construct()
	{
		global $regexdef;
		$this->regexdef = $regexdef;
		if(isset($_SESSION['repost_return_id']))
		{
			unset($_SESSION['repost_return_id']);
		}
		if(isset($_SESSION['repost_status_okay']))
		{
			unset($_SESSION['repost_status_okay']);
		}
		$this->get_return_id();
	}
	
	
	/***************************************************************************************************
  * valcheckbox() - valpost a checkbox, add it to running list of checked values
  ***************************************************************************************************/
	function valcheckbox($name, $ifchecked=true, $ifnotchecked=false)
	{
		$posted = $this->valpost($name, 'checkbox', false);
		if(!(empty($posted)))
		{
			array_push($this->checkbox_list, $ifchecked);
			return true;
		}
		elseif($ifnotchecked !== false)
		{
			array_push($this->checkbox_list, $ifnotchecked);
			return false;
		}
		else
		{
			return false;
		}
	}
	
	
	/***************************************************************************************************
  * clear_checkbox_list()
  ***************************************************************************************************/
	function clear_checkbox_list()
	{
		$this->checkbox_list = array();
	}
	
	
	/***************************************************************************************************
  * start_checkbox_list()
  ***************************************************************************************************/
	function output_checkbox_list($delim=', ')
	{
		return (empty($this->checkbox_list)) ? '' : implode($delim, $this->checkbox_list);
	}
	
	
	/***************************************************************************************************
  * convert_checkbox()
  ***************************************************************************************************/
	function convert_checkbox($checkbox_value, $value_if_checked='true', $value_if_unchecked='false')
	{
		return ((empty($checkbox_value)) ? $value_if_unchecked : $value_if_checked);
	}
	
	
	/***************************************************************************************************
  * set_fail() - manually set validation failure, if theres some other reason that a form needs to
  * fail and repost
  ***************************************************************************************************/
	function set_fail()
	{
		$this->fail_repost = true;
	}
	
	
	/***************************************************************************************************
  * force_repost() - write repost to session vars, regardless of whether validation passed or
  * failed. Still, only valid fields will be saved
  ***************************************************************************************************/
	function force_repost($manually_force_status='')
	{
		$actual_status = (!($this->fail_repost));
		$manually_force_status = trim(strtolower($manually_force_status));
		$this->write_repost_to_session();
		if($manually_force_status == 'pass')
		{
			$this->set_status_okay();
		}
		elseif($manually_force_status == 'fail')
		{
			$this->set_fail();	//doesn't really actually do anything at this point
		}
		else
		{
			if($actual_status)
			{
				$this->set_status_okay();
			}
		}
		return $actual_status;
	}
	
	
	/***************************************************************************************************
  * set_status_okay() - if you want to push form values using val->passed, but don't want an error
  * message or whatever, use this to indicate that the repost is due to nonerror in session vars
  ***************************************************************************************************/
	function set_status_okay($okay=true)
	{
		$_SESSION['repost_status_okay'] = $okay;
		return true;
	}
	
	
	/***************************************************************************************************
  * store_repost_set() - store a set of form values indexed by form id, in case of multipage form flow
  ***************************************************************************************************/
	function store_repost_set()
	{
		$store = array('repost_return_id'	=>	$_SESSION['repost_return_id'],
									 'repost_passed_fields'	=>	$_SESSION['repost_passed_fields'],
									 'repost_passed_values'	=>	$_SESSION['repost_passed_values'],
									 'repost_failed_fields'	=>	$_SESSION['repost_failed_fields'],
									 'repost_status_okay'		=>	$_SESSION['repost_status_okay']);
		$_SESSION['repost_sets'][$this->repost_return_id] = $store;
	}
	
	/***************************************************************************************************
  * write_repost_to_session() - if form failed, write info to session to indicate which form will
  * be repopulated w/repost
  ***************************************************************************************************/
	function write_repost_to_session()
	{
		if($this->repost_return_id !== false)
		{
			$_SESSION['repost_return_id'] = $this->repost_return_id;
			$_SESSION['repost_passed_fields'] = $this->passed_fields;
			$_SESSION['repost_passed_values'] = $this->passed_values;
			$_SESSION['repost_failed_fields'] = $this->failed_fields;
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	/***************************************************************************************************
  * get_return_id() - get return id of form that submitted, if applicable
  ***************************************************************************************************/
	function get_return_id()
	{
		if(isset($_POST["return_id"]))
		{
			$this->repost_return_id = $_POST["return_id"];
			return true;
		}
		else
		{
			return false;
		}
	}
	
	
	/***************************************************************************************************
  * passed() - all inputs have been run through, did they all pass validation? also write session
  * repost vars here.
  ***************************************************************************************************/
	function passed()
	{
		if($this->fail_repost)
		{
			$this->write_repost_to_session();
			return false;
		}
		else
		{
			return true;
		}
	}
	
	/***************************************************************************************************
	* select_regex() - get regex via friendly name, if blankable
  ***************************************************************************************************/
	function select_regex($type, $minlength=false, $maxlength=false)
	{
		return (isset($this->regexdef[$type])) ? $this->regexdef[$type] : false;
	}
	
	
  /***************************************************************************************************
  * grab_post() - get raw value of post field
  ***************************************************************************************************/
	function grab_post($field_name)
	{
		if(isset($_POST["$field_name"]))
		{
			$raw_post_value = $_POST["$field_name"];
			if($this->stripslashes)
			{
				$raw_post_value = stripslashes($raw_post_value);
			}
			$raw_post_value = html_entity_decode($raw_post_value);
		}
		else
		{
			$raw_post_value = '';	//return blank so we can prompt to complete blank fields (instead of mystery !isset)
		}
		return $raw_post_value;
	}
	
	
	/***************************************************************************************************
 * grab_get() - get raw value of get field
 ***************************************************************************************************/
	function grab_get($field_name)
	{
		return (isset($_GET[$field_name])) ? $_GET[$field_name] : $this->default_empty_superglobal;
	}
	
	
	/***************************************************************************************************
 * valget_now() - get raw value of get field, validate, return if valid
 ***************************************************************************************************/
	function valget_now($field_name, $regex_type)
	{
		$gotget = $this->grab_get($field_name);
		if(!(empty($gotget)))
		{
			$selected_regex = $this->select_regex($regex_type);
			if($selected_regex !== false)
			{
				return $this->preg_validate($gotget, $selected_regex, true);
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
	}
	
	
	/***************************************************************************************************
	* preg_validate() - preg_match with appropriate regex, return trimmed input if match, false if not
	***************************************************************************************************/
	function preg_validate($input, $regex=false, $dotrim=true)
	{
		if(empty($regex))
		{
			return false;	//woops you passed a blank regex.
		}
		$input = ($dotrim ? trim($input) : $input);
		return ((preg_match($regex, $input)) ? $input : false);
	}
	
	
	/***************************************************************************************************
	* dumb_push() - grab post and push to session for repost as-is, used for temporarily storing form
	* values when doing intermediate submit operations, dont htmlentitize.
	***************************************************************************************************/
	function dumb_push($fields)
	{
		if(!(is_array($fields)))
		{
			$fields = array($fields);
		}
		foreach($fields as $field_name)
		{
			if((!(in_array($field_name, $this->passed_fields))) && (!(in_array($field_name, $this->failed_fields))))
			{
				$posted = $this->grab_post($field_name);
				array_push($this->passed_fields, $field_name);
				array_push($this->passed_values, $posted);
			}
		}
	}
	
	
	/***************************************************************************************************
	* longtext_valpost() - get a field potentially too long for preg_match'ing
	***************************************************************************************************/
	function longtext_valpost($field_name, $max_length=1000, $required=true, $min_length=0)
	{
		$gotpost = '' . $this->grab_post($field_name);
		if((strlen($gotpost) < $min_length) && ($required))
		{
			$this->fail_repost = true;
			array_push($this->failed_fields, $field_name);
			return false;
		}
		elseif(strlen($gotpost) > $max_length)
		{
			$gotpost = substr($gotpost, 0, $max_length);
		}
		array_push($this->passed_fields, $field_name);
		array_push($this->passed_values, $gotpost);
		return $gotpost;
	}
	
	
	/***************************************************************************************************
	* valpost() - grab, validate, and set errors for a post var.
	***************************************************************************************************/
	function valpost($field_name, $regex_type, $required=true, $block_repost=false, $method="post", $process_as_list_delim=null, $minlength=false, $maxlength=false)
	{
		$method = strtolower($method);
		if($method == "post")
		{
			$raw_post = $this->grab_post("$field_name");
		}
		elseif($method = "get")
		{
			$raw_post = $this->grab_get("$field_name");	//really not going to be using get that much.
		}
		if($raw_post !== false)
		{
			$selected_regex = $this->select_regex($regex_type, $minlength, $maxlength);
			if($selected_regex !== false)
			{
				if($regex_type == "password")
				{
					$dotrim = false;
				}
				else
				{
					$dotrim = true;
				}
				if($regex_type == "long_textarea")
				{
					//$matched = "";
					//$matched .= htmlentities($raw_post);
					//$matched = trim($matched);
					$matched = trim('' . $raw_post);
					if((strlen($matched)) > $this->longtext_maxlength)
					{
						$matched = substr($matched, 0, $this->longtext_maxlength);
					}
				}
				elseif($process_as_list_delim !== null)
				{
					$raw_list_array = explode("$process_as_list_delim", $raw_post);
					if(is_array($raw_list_array))
					{
						$matched = "";
						for($i = 0; $i < count($raw_list_array); $i ++)
						{
							$raw_element = $raw_list_array[$i];
							$matched_element = $this->preg_validate($raw_element, $selected_regex, $dotrim);
							if($matched_element === false)
							{
								$matched = false;
								break;
							}
							else
							{
								if((strlen($matched)) > 0)
								{
									$matched .= $process_as_list_delim;
								}
								$matched .= $matched_element;
							}
						}
					}
				}
				else
				{
					$matched = $this->preg_validate($raw_post, $selected_regex, $dotrim);
				}
				if($matched !== false)
				{
					array_push($this->passed_fields, $field_name);
					array_push($this->passed_values, $matched);
					return $matched;
				}
			}
		}
		if($required)
		{
			$this->fail_repost = true;
			array_push($this->failed_fields, $field_name);
		}
		return false;
	}
	
}