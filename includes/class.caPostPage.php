<?php
/****************************************************************************************************
 * file: class.caPostPage.php
 * author: chris w., webdevseattle
 * lastrev: 01/28/2012
 * desc: class for action/verifier pages
 ***************************************************************************************************/


/****************************************************************************************************
 * class caPostPage
 ***************************************************************************************************/
class caPostPage
{
	var $valid_submits;
	var $referring_page = false;
	var $path;
	var $rootpath;
	
	/***************************************************************************************************
	* __construct()
	***************************************************************************************************/
	function __construct($path="")
	{
		$this->path = $path;
		$this->set_rootpath();
		$this->get_referring_page();
		return true;
	}
	
	
	/***************************************************************************************************
 * set_rootpath() - set rootpath var with path from this page to root of buzzsys
 ***************************************************************************************************/
	function set_rootpath()
	{
		global $rootpath;
		$path = $this->path;
		$slashes = substr_count("$path", "/");
		if($slashes > 0)
		{
			$depth = $slashes;
		}
		else
		{
			if((strlen($path)) > 0)
			{
				$depth = 1;
			}
			else
			{
				$depth = 0;
			}
		}
		$makepath = "";
		for($i = 0; $i < $depth; $i ++)
		{
			$makepath .= "../";
		}
		$this->rootpath = $makepath;
		$rootpath = $this->rootpath;
		return true;
	}
	
	
	/***************************************************************************************************
	* header_kick() - done with this page, kick to appropriate page via 301.
	***************************************************************************************************/
	function header_kick($destination=false, $exit=true, $append_querystring=false)
	{
		if($destination === false)
		{
			$destination = $this->referring_page;
		}
		if(($destination == '') || ($destination == false) || ($destination == null))
		{
			$destination = 'about:blank';	//avoid looping on blank referrals
		}
		elseif($append_querystring !== false)
		{
			$destination = (strpos($destination, '?') === false) ? $destination . '?' . $append_querystring : $destination . '&' . $append_querystring;
		}
		/* header("HTTP/1.1 301 Moved Permanently"); */
		header ("Location: $destination");
		if($exit)
		{
			exit();
		}
		return true;
	}
	
	
	/***************************************************************************************************
	* define_valid_submits() - define valid submit value (i.e. actions) for this actionpage
	***************************************************************************************************/
	function define_valid_submits($submit_list)
	{
		$this->valid_submits = $this->list_to_array($submit_list);
		return true;
	}
	
	
	/***************************************************************************************************
	* define_valid_submits() - define valid submit value (i.e. actions) for this actionpage
	***************************************************************************************************/
	function get_submit($submitname="submit")
	{
		$posted_submit = $_POST["$submitname"];
		if(in_array($posted_submit, $this->valid_submits))
		{
			return $posted_submit;
		}
		else
		{
			$this->header_kick($this->referring_page);
			return false;
		}
	}
	
	
	/***************************************************************************************************
	* get_refpage() - get referrer
	***************************************************************************************************/
	function get_referring_page()
	{
		if(isset($_SERVER['HTTP_REFERER']))
		{
			$this->referring_page = $_SERVER['HTTP_REFERER'];
		}
		else
		{
			$this->referring_page = false;
		}
		return $this->referring_page;
	}
	
	
	/***************************************************************************************************
	* postif() - get posted value if it exists
	***************************************************************************************************/
	function postif($field)
	{
		$posted = false;
		if(isset($_POST["$field"]))
		{
			$posted = $_POST["$field"];
		}
		return $posted;
	}
	
	
	/***************************************************************************************************
	* sessif() - get session var if it exists
	***************************************************************************************************/
	function sessif($field, $destroy=false)
	{
		$sessed = false;
		if(isset($_SESSION["$field"]))
		{
			$sessed = $_SESSION["$field"];
			if($destroy)
			{
				unset($_SESSION["$field"]);
			}
		}
		return $sessed;
	}
	
	
	/***************************************************************************************************
	* getif() - get get var if it exists
	***************************************************************************************************/
	function getif($field)
	{
		$got = false;
		if(isset($_GET["$field"]))
		{
			$got = $_GET["$field"];
		}
		return $got;
	}
	
	
	/***************************************************************************************************
	* set_return_message() - set session result message and type
	***************************************************************************************************/
	function set_return_message($message, $type='notice')
	{
		$_SESSION['result_message'] = $message;
		$_SESSION['result_type'] = $type;
		return true;
	}
	
	
	/***************************************************************************************************
	* paramcount() - verify that the correct number of params were given for an admin command
	***************************************************************************************************/
	function paramcount($correct_count, $params)
	{
		//stubby
		return true;
	}
	
	
	/***************************************************************************************************
	* searchchecks() - somewhat specialized function for dynamic checkboxes - search for any POST keys
	* that match prefix, and return the remainder of the keyname i.e. find delete_image_27 and return 27
	***************************************************************************************************/
	function searchchecks($prefix)
	{
		$found = array();
		$prefix_len = strlen($prefix);
		foreach($_POST as $key => $value)
		{
			$prefix_pos = stripos($key, $prefix);
			if($prefix_pos !== false)
			{
				$prefix_pos += $prefix_len;
				$suffix = substr($key, $prefix_pos, (strlen($key) - $prefix_pos));
				array_push($found, $suffix);
			}
		}
		return $found;
	}
	
}


?>