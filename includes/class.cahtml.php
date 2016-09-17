<?php
/**********************************************************************************************************************
 * file: class.cahtml.php
 * author: chris w., webdevseattle
 * lastrev: 01/28/2012
 * desc: lazy html templating shortcuts.
 *********************************************************************************************************************/


/**********************************************************************************************************************
 * class cahtml - lazy html echo base class, near-final rev
 *********************************************************************************************************************/
class cahtml
{
	private $do_echo = true;						//actually echo instead of just return
	private $do_queue = false;
	private $do_return = false;
	private $do_newlines = true;				//append newlines when echoing, in source, not actual breaks
	
	private $default_tag = array();
	var $output_queue = '';
	private $closetags = array();
	
	var $entitize_content = false;			//if true, run all passed $content vars through htmlentities

	
	/*********************************************************************************************************************
  * set_output() - choose where output from this class will go
  *********************************************************************************************************************/
	function set_output($echo_on=true, $queue_on=false, $return_on=false)
	{
		$this->do_echo = $echo_on;
		$this->do_queue = $queue_on;
		$this->do_return = $return_on;
	}

	
	/*********************************************************************************************************************
  * set_format() - choose how output from this class will be formatted
  *********************************************************************************************************************/
	function set_format($do_newlines=true)
	{
		$this->do_newlines = $do_newlines;
	}

	
	/*********************************************************************************************************************
	* clear() - clear floats
  *********************************************************************************************************************/
	function clear()
	{
		return $this->xecho('<div style="clear: both; float: none;"></div>');
	}
	
	
	/*********************************************************************************************************************
  * set_default_tag()
  *********************************************************************************************************************/
	function set_default_tag($tag='', $class='', $style='', $extra='')
	{
		$this->default_tag['tag'] = $tag;
		$this->default_tag['class'] = $class;
		$this->default_tag['style'] = $style;
		$this->default_tag['extra'] = $extra;
	}
	
	
	/*********************************************************************************************************************
	* tag() - generic tag
  *********************************************************************************************************************/
	function tag($tag=false, $content, $class='', $style='', $id='', $extra='')
	{
		$content = ($this->entitize_content) ? htmlentities('' . $content) : $content;
		if($tag == false)
		{
			$tag = $this->default_tag['tag'];
			$class = $this->default_tag['class'];
			$style = $this->default_tag['style'];
			$extra = $this->default_tag['extra'];
		}
		$class = ($class != '' ? ' class="' . $class . '"' : '');
		$style = ($style != '' ? ' style="' . $style . '"' : '');
		$id = ($id != '' ? ' id="' . $id . '"' : '');
		$extra = ($extra != '' ? ' ' . $extra : '');
		return $this->xecho('<' . $tag . $class . $style . $id . $extra . '>' . $content . '</' . $tag . '>');
	}
	
	
	/*********************************************************************************************************************
	* stag() - generic self closing tag
  *********************************************************************************************************************/
	function stag($tag=false, $class='', $style='', $id='', $extra='')
	{
		if($tag == false)
		{
			$tag = $this->default_tag['tag'];
			$class = $this->default_tag['class'];
			$style = $this->default_tag['style'];
			$extra = $this->default_tag['extra'];
		}
		$class = ($class != '' ? ' class="' . $class . '"' : '');
		$style = ($style != '' ? ' style="' . $style . '"' : '');
		$id = ($id != '' ? ' id="' . $id . '"' : '');
		$extra = ($extra != '' ? ' ' . $extra : '');
		return $this->xecho('<' . $tag . $class . $style . $id . $extra . ' />');
	}
	
	
	/*********************************************************************************************************************
	* otag() - opentag, store tag to close later
  *********************************************************************************************************************/
	function otag($tag=false, $class='', $style='', $id='', $extra='')
	{
		if($tag == false)
		{
			$tag = $this->default_tag['tag'];
			$class = $this->default_tag['class'];
			$style = $this->default_tag['style'];
			$extra = $this->default_tag['extra'];
		}
		$class = ($class != '' ? ' class="' . $class . '"' : '');
		$style = ($style != '' ? ' style="' . $style . '"' : '');
		$id = ($id != '' ? ' id="' . $id . '"' : '');
		$extra = ($extra != '' ? ' ' . $extra : '');
		array_push($this->closetags, $tag);
		return $this->xecho('<' . $tag . $class . $style . $id . $extra . '>');
	}
	
	
	/*********************************************************************************************************************
  * ctag() - close open tag
  *********************************************************************************************************************/
	function ctag($close=1)
	{
		$close = ($close == 'all' ? count($this->closetags) : $close);
		$toecho = '';
		for($i = 0; $i < $close; $i ++)
		{
			$thisclose = array_pop($this->closetags);
			$toecho .= '</' . $thisclose . '>';
		}
		return $this->xecho($toecho);
	}
	
	
	/*********************************************************************************************************************
	* itag() - image tag
  *********************************************************************************************************************/
	function imgtag($src, $class='', $style='', $id='', $extra='', $title_alt='')
	{
		if(!(empty($src)))	//src="" is disasterous.
		{
			$extra .= ' src="' . $src . '"';
			$extra .= ($title_alt == '' ? '' : ' alt="' . $title_alt . '" title="' . $title_alt . '"');
			return $this->stag('img', $class, $style, $id, $extra);
		}
		else
		{
			return false;
		}
	}
	
	
	/*********************************************************************************************************************
	* rtag() - repeating tag, apply same tag to a list of items.
  *********************************************************************************************************************/
	function rtag($tag, $list, $class='', $style='', $extra='', $list_delim=',')
	{
		if(!(is_array($list)))
		{
			$list = explode($list_delim, $list);
		}
		foreach($list as $item)
		{
			$item = trim($item);
			$this->tag($tag, $item, $class, $style, '', $extra);
		}
		return true;
	}
	
	
	/*********************************************************************************************************************
	* link() - shortcut to write content to page enclosed in specified tag
  *********************************************************************************************************************/
	function linktag($destination, $content, $class='', $style='', $id='', $extra='', $title_alt='')
	{
		$content = ($this->entitize_content) ? htmlentities('' . $content) : $content;
		$extra .= ' href="' . $destination . '"';
		$extra .= ($title_alt == '' ? '' : ' alt="' . $title_alt . '" title="' . $title_alt . '"');
		return $this->tag('a', $content, $class, $style, $id, $extra);
	}
	function link($destination, $content, $class='', $style='', $id='', $extra='', $title_alt='')
	{
		return $this->linktag($destination, $content, $class, $style, $id, $extra, $title_alt);
	}
	
	
	/*********************************************************************************************************************
  * nontag() - simple elements, optionally repeating
  *********************************************************************************************************************/
	function nontag($content, $repeat=1)
	{
		$content = ($this->entitize_content) ? htmlentities('' . $content) : $content;
		$toecho = '';
		for($i = 0; $i < $repeat; $i ++)
		{
			$toecho .= $content;
		}
		return $this->xecho($toecho);
	}

	
	/*********************************************************************************************************************
	* nbsp() - output nonbreaking spaces
  *********************************************************************************************************************/
	function nbsp($number=1)
	{
		return $this->nontag('&nbsp;', $number);
	}
	
	
	/*********************************************************************************************************************
	* br() - output breaks
  *********************************************************************************************************************/
	function br($breaks=1)
	{
		return $this->nontag('<br />', $breaks);
	}
	
	
	/*********************************************************************************************************************
	* jslink() - make a link with only javascript action, no href
  *********************************************************************************************************************/
	function jslinktag($content=false, $onclick='', $onmouseover='', $onmouseout='', $class='', $style='', $id='', $extra='', $title_alt='', $img=false)
	{
		$content = ($this->entitize_content) ? htmlentities('' . $content) : $content;
		$extra .= ($onclick != '' ? ' onclick="' . $onclick . '"' : '');
		$extra .= ($onmouseover != '' ? ' onmouseover="' . $onmouseover . '"' : '');
		$extra .= ($onmouseout != '' ? ' onmouseout="' . $onmouseout . '"' : '');
		$extra .= ($title_alt == '' ? '' : ' alt="' . $title_alt . '" title="' . $title_alt . '"');
		$content = ($content == false && (!(empty($img)))) ? '<img src="' . $img . '" />' : $content;
		return $this->tag('a', $content, $class, $style, $id, $extra);
	}
		
	
	/*********************************************************************************************************************
	* olink() - open link tag
  *********************************************************************************************************************/
	function olink($destination='', $class='', $style='', $id='', $extra='')
	{
		$extra = ($extra == '' ? 'href="' . $destination . '"' : $extra . ' href="' . $destination . '"');
		return $this->otag('a', $class, $style, $id, $extra);
	}
	
	
	/*********************************************************************************************************************
	* clink() - close link, basically a ctag but added for clarity
  *********************************************************************************************************************/
	function clink()
	{
		return $this->ctag();
	}
	
	
	/*********************************************************************************************************************
	* jstag() - output script item
  *********************************************************************************************************************/
	function jstag($content)
	{
		return $this->xecho('<script type="text/javascript">' . $content . '</script>');
	}
	
	
	/*********************************************************************************************************************
	* xecho() - output or actually echo.
	*********************************************************************************************************************/
	function xecho($text)
	{
		if($this->do_newlines)
		{
			$text .= "\n";
		}
		if($this->do_queue)
		{
			$this->output_queue .= $text;
		}
		if($this->do_echo)
		{
			echo $text;
		}
		if($this->do_return)
		{
			return $text;
		}
		else
		{
			return true;
		}
	}
	
	
	/*********************************************************************************************************************
	* dump_queue() - output all queue and optionally flush
	*********************************************************************************************************************/
	function dump_queue($flush=true)
	{
		echo $this->output_queue;
		if($flush)
		{
			$this->output_queue = '';
		}
		return true;
	}
	
	
	/*********************************************************************************************************************
  * set_cookie()
  *********************************************************************************************************************/
	function set_cookie($varname, $value, $expire_days=1)
	{
		$this->jstag('SetCookie(' . "'$varname', " . "'$value', " . "'$expire_days'" . ');');
	}
	
	
	/*********************************************************************************************************************
  * get_cookie()
  *********************************************************************************************************************/
	function get_cookie($cookiename, $destroy=false)
	{
		if(isset($_COOKIE["$cookiename"]))
		{
			$gotvalue = $_COOKIE["$cookiename"];
			if($destroy)
			{
				$this->set_cookie($cookiename, false, 0);
			}
		}
		else
		{
			$gotvalue = false;
		}
		return $gotvalue;
	}
	
	
	/*********************************************************************************************************************
	* getif() - get get var if it exists
	*********************************************************************************************************************/
	function getif($field)
	{
		return (isset($_GET["$field"]) ? $_GET["$field"] : false);
	}
	
	
	/*********************************************************************************************************************
	* postif() - get posted value if it exists
	*********************************************************************************************************************/
	function postif($field)
	{
		return (isset($_POST["$field"]) ? $_POST["$field"] : false);
	}
	
	
	/*********************************************************************************************************************
	* sessif() - get session var if it exists
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
	
	
}
?>