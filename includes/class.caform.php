<?php
/*********************************************************************************************************************
 * file: class.caform.php
 * author: chris w.
 * lastrev: 06/25/2011
 * desc: basic forms class
 * depends: requires js file if external js functions used
 ********************************************************************************************************************/


/**********************************************************************************************************************
 * class caform - basic forms class, advanced rev
 *********************************************************************************************************************/
class caform extends cahtml
{
	var $external_js = array('radio_display_toggle'					=>		'radio_display_toggle',
													 'disable_unhide_buttons'				=>		'disable_by_class'
													);
	var $failstyle = 'border: 2px inset red;';
	var $label_element = 'label';
	var $rules_class = '';	//css class for rules labels, to differentiate from field labels.
	private $unrepostable_elements = array('submit', 'hidden', 'password');	//element types that should never be reposted
	
	var $wrapper_div_id = false;		//use to store id of div that hides this form, if hidden.
	var $has_cancel = false;				//if true, output a cancel button at the end of this form.
	var $return_id = false;					//use this to ID forms when posting back failed forms to pages w/multiple forms
	var $is_reposted = false;				//if true, then this form failed validation and has some values coming back to it
	
	var $repost_passed_fields = array();
	var $repost_passed_values = array();
	var $repost_failed_fields = array();
	var $readonly_toggle = false;
	private $default_tag = array();
	private $closetags = array();
	
	
	/*********************************************************************************************************************
  * __construct()
  *********************************************************************************************************************/
	function __construct($action='', $id=false, $class=false, $style=false, $extra=false, $method='POST')
	{
		if($id != false)
		{
			$this->return_id = $id;
			$this->retrieve_repost();
		}
		$id = ($id != false ? ' id="' . $id . '"' : '');
		$class = ($class != false ? ' class="' . $class . '"' : '');
		$style = ($style != false ? ' style="' . $style . '"' : '');
		$extra = ($extra != false ? ' ' . $extra : '');
		$this->set_output(false, true, false);
		$this->output_queue = '';
		$this->xecho('<form action="' . $action . '" method="' . $method . '"' . $class . $style . $id . $extra . '>');
		return true;
	}
	
	
	/*********************************************************************************************************************
  * add() - add text / markup directly to output queue
  *********************************************************************************************************************/
	function add($text)
	{
		$this->xecho($text);
	}
	
	
	/*********************************************************************************************************************
  * retrieve_repost() - if form failed validation, get reposted field values from session.
  *********************************************************************************************************************/
	function retrieve_repost()
	{
		if(isset($_SESSION['repost_sets'][$this->return_id]))
		{
			$this->is_reposted = true;
			$this->repost_passed_fields = $_SESSION['repost_sets'][$this->return_id]['repost_passed_fields'];
			$this->repost_passed_values = $_SESSION['repost_sets'][$this->return_id]['repost_passed_values'];
			$this->repost_failed_fields = $_SESSION['repost_sets'][$this->return_id]['repost_failed_fields'];
			unset($_SESSION['repost_sets'][$this->return_id]);
		}
		elseif($this->sessif('repost_return_id', false) == $this->return_id)
		{
			$this->is_reposted = true;
			$this->repost_passed_fields = $this->sessif('repost_passed_fields', true);
			$this->repost_passed_values = $this->sessif('repost_passed_values', true);
			$this->repost_failed_fields = $this->sessif('repost_failed_fields', true);
			unset($_SESSION['repost_return_id']);
		}
	}
	
	
	/*********************************************************************************************************************
  * get_repost_value() - get reposted field value, return original field value if not found
  *********************************************************************************************************************/
	function get_repost_value($field_name, $value)
	{
		$repost_key = array_search($field_name, $this->repost_passed_fields);
		return ($repost_key !== false) ? $this->repost_passed_values[$repost_key] : $value;
	}
	
	
	/*********************************************************************************************************************
  * get_repost_value() - return failstyle if field failed validation, return orig style if not
  *********************************************************************************************************************/
	function restyle_if_failed($field_name, $existing_style='')
	{
		$repost_key = array_search($field_name, $this->repost_failed_fields);
		return ($repost_key !== false ? $existing_style . ' ' . $this->failstyle : $existing_style);
	}
	
	
	/*********************************************************************************************************************
  * add_cancel() - add cancel button at end of form
  *********************************************************************************************************************/
	function add_cancel()
	{
		$this->has_cancel = true;
	}
	
	
	/*********************************************************************************************************************
  * add_input() - add a single input element
  *********************************************************************************************************************/
	function add_input($type, $name, $value='', $id='', $class='', $style='', $extra='')
	{
		if($this->is_reposted)
		{
			if(!(in_array($type, $this->unrepostable_elements)))
			{
				$value = $this->get_repost_value($name, $value);
			}
			$style = $this->restyle_if_failed($name, $style);
		}
		$class = ($class != '' ? ' class="' . $class . '"' : '');
		$style = ($style != '' ? ' style="' . $style . '"' : '');
		$id = ($id != '' ? ' id="' . $id . '"' : '');
		$extra = ($extra != '' ? ' ' . $extra : '');
		if($this->readonly_toggle)
		{
			$extra .= ($type == 'submit') ? ' disabled="disabled"' : ' readonly="readonly"';
		}
		$this->xecho('<input type="' . $type . '" name="' . $name . '" value="' . $value . '"' . $id . $class . $style . $extra . ' />');
	}
	
	
	/*********************************************************************************************************************
  * add_label() - add label to form
  *********************************************************************************************************************/
	function label($text, $class='', $style='', $extra='', $title_alt='')
	{
		$class = ($class != '' ? ' class="' . $class . '"' : '');
		$style = ($style != '' ? ' style="' . $style . '"' : '');
		$title_alt = ($title_alt != '' ? ' alt="' . $title_alt . '" title="' . $title_alt . '"' : '');
		$extra = ($extra != '' ? ' ' . $extra : '');
		$this->xecho('<' . $this->label_element . ' ' . $class . $style . $extra . $title_alt . '>' . $text . '</' . $this->label_element . '>');
	}
	
	
	/*********************************************************************************************************************
  * add_text() - add text input to form
  *********************************************************************************************************************/
	function add_text($name, $value='', $rules='', $class='', $style='', $id='', $extra='')
	{
		$this->add_input('text', $name, $value, $id, $class, $style, $extra);
		if($rules != '')
		{
			$this->label($rules, $this->rules_class);
		}
	}
	
	
	/*********************************************************************************************************************
  * add_password() - add password input to form
  *********************************************************************************************************************/
	function add_password($name, $rules='', $class='', $style='', $id='')
	{
		$this->add_input('password', $name, '', $id, $class, $style);
		if($rules != '')
		{
			$this->label($rules, $this->rules_class);
		}
	}
	
	
	/*********************************************************************************************************************
  * add_submit() - add submit to form
  *********************************************************************************************************************/
	function add_submit($name='submit', $value='Submit', $doconfirm=false, $confirm_text='', $id='', $class='', $style='', $extra='')
	{
		$extra .= ($doconfirm ? ' onclick="return confirm(' . "'$confirm_text'" . ');"' : '');
		$this->add_input('submit', $name, $value, $id, $class, $style, $extra);
	}
	
	
	/*********************************************************************************************************************
  * add_select() - add select input to form, with list of options
  *********************************************************************************************************************/
	function add_select($name, $optionlist, $valuelist=false, $default_option=false, $class='', $style='', $id='', $extra='')
	{
		if($this->is_reposted)
		{
			$default_option = $this->get_repost_value($name, $default_option);
			$style = $this->restyle_if_failed($name, $style);
		}
		$count = count($optionlist);
		if(is_array($valuelist))
		{
			if($count != count($valuelist))
			{
				$valuelist = $optionlist;
			}
		}
		else
		{
			$valuelist = $optionlist;
		}
		$class = ($class != '' ? ' class="' . $class . '"' : '');
		$style = ($style != '' ? ' style="' . $style . '"' : '');
		$id = ($id != '' ? ' id="' . $id . '"' : '');
		$extra = ($extra != '' ? ' ' . $extra : '');
		$extra .= ($this->readonly_toggle) ? ' readonly="readonly"' : '';
		$this->xecho('<select name="' . $name . '"' . $class . $style . $id . $extra . '>');
		for($i = 0; $i < $count; $i ++)
		{
			$selected = (($default_option !== false) && ($default_option == $optionlist[$i]) ? ' selected="selected"' : '');
			$this->xecho('<option value="' . $valuelist[$i] . '"' . $selected . '>' . $optionlist[$i] . '</option>');
		}
		$this->xecho('</select>');
	}
	
	
	/*********************************************************************************************************************
  * add_checkbox() - add single checkbox input to form
  *********************************************************************************************************************/
	function add_checkbox($name, $label='', $checked=false, $class='', $style='', $value=false, $extra='')
	{
		if($this->is_reposted)
		{
			$style = $this->restyle_if_failed($name, $style);
			$checked = ($this->get_repost_value($name, $value) != $value) ? ' checked' : '';
		}
		else
		{
			$checked = ($checked != false) ? ' checked' : '';
		}
		$class = ($class != '' ? ' class="' . $class . '"' : '');
		$style = ($style != '' ? ' style="' . $style . '"' : '');
		$value = ($value != false ? ' value="' . $value . '"' : '');
		$extra = ($extra != '' ? ' ' . $extra : '');
		$extra .= ($this->readonly_toggle) ? ' disabled="disabled"' : '';
		$this->xecho('<input type="checkbox" name="' . $name . '"' . $checked . $class . $style . $value . $extra . '>');
		if($label != '')
		{
			$this->label($label);
		}
	}
	
	
	/*********************************************************************************************************************
  * add_textarea() - add a textarea to form
  *********************************************************************************************************************/
	function add_textarea($name, $columns='', $rows='', $value='', $class='', $style='', $id='', $extra='')
	{
		if($this->is_reposted)
		{
			$style = $this->restyle_if_failed($name, $style);
			$value = $this->get_repost_value($name, $value);
		}
		$value = htmlentities($value);
		$class = ($class != '' ? ' class="' . $class . '"' : '');
		$style = ($style != '' ? ' style="' . $style . '"' : '');
		$columns = ($columns != '') ? ' cols="' . $columns . '"' : '';
		$rows = ($rows != '') ? ' rows="' . $rows . '"' : '';
		$id = ($id != '' ? ' id="' . $id . '"' : '');
		$extra = ($extra != '' ? ' ' . $extra : '');
		$extra .= ($this->readonly_toggle) ? ' readonly="readonly"' : '';
		$this->xecho('<textarea name="' . $name . '"' . $columns . $rows . $class . $style . $id . $extra . '>' . $value . '</textarea>');
	}
	
	
	/*********************************************************************************************************************
  * add_radios() - add a set of radio buttons to form, display_toggles is optional array of ids of
  * other elements on this form whose visibility can be toggled by this radio set.
  *********************************************************************************************************************/
	function add_radios($name, $optionlist, $valuelist=false, $vertical=false, $default_option='', $class='', $style='', $display_toggles=false)
	{
		if($this->is_reposted)
		{
			$default_option = $this->get_repost_value($name, $default_option);
			$style = $this->restyle_if_failed($name, $style);
		}
		$class = ($class != '' ? ' class="' . $class . '"' : '');
		$style = ($style != '' ? ' style="' . $style . '"' : '');
		$count = count($optionlist);
		if(is_array($valuelist))
		{
			if($count != count($valuelist))
			{
				$valuelist = $optionlist;
			}
		}
		else
		{
			$valuelist = $optionlist;
		}
		for($i = 0; $i < $count; $i ++)
		{
			$checked = ($default_option === $optionlist[$i] ? ' checked' : '');
			$onclick = (isset($display_toggles[$i]) ? ' onclick="' . $this->external_js['radio_display_toggle'] . "('" . $display_toggles[$k] . "'" . ');"' : '');
			$this->xecho('<input type="radio" name="' . $name . '" value="' . $thisvalue . '"' . $checked . $class . $style . $onclick . '>');
			$this->label($thisvalue);
			if($vertical)
			{
				$this->br();
			}
		}
	}
	
	
	/*********************************************************************************************************************
  * add_hidden() - add hidden input to form
  *********************************************************************************************************************/
	function add_hidden($name, $value='', $id='')
	{
		$this->add_input('hidden', $name, $value, $id);
	}
	
	
	/*********************************************************************************************************************
  * output() - display the form
  *********************************************************************************************************************/
	function output($disable_return_id=false)
	{
		$this->finalize($disable_return_id);
		$this->dump_queue();
	}
	
	
	/*********************************************************************************************************************
  * finalize() - add items like cancel submit etc that were added out of order and belong at end of form.
  *********************************************************************************************************************/
	function finalize($disable_return_id=false)
	{
		if($this->has_cancel)
		{
			$this->add_submit('submit', 'Cancel');
		}
		if(($this->return_id !== false) && !($disable_return_id))
		{
			$this->add_hidden('return_id', $this->return_id);
		}
		$this->xecho('</form>');
	}
	
	
	/*********************************************************************************************************************
  * output_and_hide() - output form in hidden div, set id to show later with jabbascript
  *********************************************************************************************************************/
	function output_and_hide($unique_wrapper_id=false, $disable_return_id=false)
	{
		if($this->is_reposted)
		{
			$this->output();	//repost, so keep form open
		}
		else
		{
			$this->wrapper_div_id = ($unique_wrapper_id === false ? 'hideform_' . $this->return_id : $unique_wrapper_id);	//attempt to make a unique id if possible
			$this->finalize();
			$this->output_queue = '<div id="' . $this->wrapper_div_id . '" style="display: none;">' . $this->output_queue . '</div>';	//wrapit.
			$this->dump_queue();
		}
	}
	
	
	/*********************************************************************************************************************
  * unhide_button() - draw button that unhides form hidden by output_and_hide
  *********************************************************************************************************************/
	function unhide_button($button_text='', $global_disable_pool=true)
	{
		if(!($this->is_reposted) && ($this->wrapper_div_id !== false))	//make sure form was hidden/unhideable
		{
			$disable_class = ($global_disable_pool ? ' class="showhide_group_disable"' : '');
			$disable_onclick = ($global_disable_pool ? ' ' . $this->external_js['disable_unhide_buttons'] . "('showhide_group_disable');" : '');
			echo '<input value="' . $button_text . '" type="button"' . $disable_class .
					 ' onclick="document.getElementById(' . "'" . $this->wrapper_div_id . "'" . ').style.display = ' . "'inherit';" . 
					 ' this.style.display = ' . "'none';" . $disable_onclick . '" />';
		}
	}
	
	
	/*********************************************************************************************************************
  * describe() - add a label to the beginning of form with instructions or whatevs
  *********************************************************************************************************************/
	function describe($text, $style='font-style: italic;')
	{
		$this->label($text, '', $style);
		$this->br(2);
	}
	
	
	/*********************************************************************************************************************
  * title() - add display title to form, h3 size by default
  *********************************************************************************************************************/
	function title($text, $element='h3')
	{
		$this->tag($element, $text);
	}
	
	
	/*********************************************************************************************************************
  * add_dateselect_group() - add dropdowns with month/date/year
  *********************************************************************************************************************/
	function add_dateselect_group($groupname, $default_time=false, $firstyear=false)
	{
		$default_time = ($default_time == false ? time() : $default_time);
		$selectmonth = date('m', $default_time);
		$selectday = date('d', $default_time);
		$selectyear = date('Y', $default_time);
		$firstyear = ($firstyear == false ? date('Y') : $firstyear);
		$lastyear = $firstyear + 12;
		if($selectyear > $lastyear)
		{
			$selectyear = $lastyear;
			$selectmonth = 1;
			$selectday = 1;
		}
		$firstmonth = 1;
		$lastmonth = 12;
		$firstday = 1;
		$lastday = 31;
		$yearlist = array();
		for($i = $firstyear; $i <= $lastyear; $i ++)
		{
			array_push($yearlist, $i);
		}
		$monthlist = array();
		for($i = $firstmonth; $i <= $lastmonth; $i ++)
		{
			array_push($monthlist, sprintf('%02d', $i));
		}
		$daylist = array();
		for($i = $firstday; $i <= $lastday; $i ++)
		{
			array_push($daylist, sprintf('%02d', $i));
		}
		$this->add_select($groupname . '_month', $monthlist, false, $selectmonth);
		$this->add_select($groupname . '_day', $daylist, false, $selectday);
		$this->add_select($groupname . '_year', $yearlist, false, $selectyear);
	}
	

}
?>