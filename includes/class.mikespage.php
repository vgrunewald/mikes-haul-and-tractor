<?php
/**********************************************************************************************************************
 * file: class.mikespage.php
 * author: chris w., webdevseattle
 * lastrev: 03/19/2012
 * desc: mike's tractor and hauling work local city page common functions
 *********************************************************************************************************************/


/**********************************************************************************************************************
 * class cahtml - lazy html echo base class, near-final rev
 *********************************************************************************************************************/
class mikespage extends cahtml
{
	var $city = 'Issaquah';
	var $default_meta_description = "Mike's Tractor and Hauling provides [city] landscaping service that is fast, personalized, and environmentally conscious. For professional hauling and landscaping, [city] WA homeowners can call Mike's for a free estimate";
	var $default_meta_keywords = '[city], landscaping, landscape, hauling, landscaping service, [city] landscaping';
	var $heading = '[city] Landscaping';
	var $services_heading = "Mike's [city] Landscaping and Hauling Services";
	
	var $gallery = array();
	
	var $servicelist = array('Grading',
													 'Retaining Walls',
													 'Excavation',
													 'Mowing',
													 'Brush Removal',
													 'Drainage',
													 'Rock Moving',
													 'Stump Removal',
													 'Post-Holes',
													 'Rototilling',
													 'Waste &amp; Debris Hauling',
													 'Asphalt Application / Removal',
													 'Deck Removal',
													 'Playground Renovation',
													 'Tree Removal');
	
	var $citylist = array('Issaquah',
												'Redmond',
												'Bellevue',
												'Factoria',
												'Eastgate',
												'Kirkland',
												'North Bend',
												'Snoqualmie',
												'Fall City',
												'Newcastle');
	
	var $zipcodes = '98029, 98027';
	
	var $mapcode = '<iframe width="300" height="180" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=issaquah,+wa&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=60.894251,96.503906&amp;ie=UTF8&amp;hq=&amp;hnear=Issaquah,+King,+Washington&amp;t=m&amp;ll=47.530184,-122.0327&amp;spn=0.083452,0.205994&amp;z=11&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=issaquah,+wa&amp;aq=&amp;sll=37.0625,-95.677068&amp;sspn=60.894251,96.503906&amp;ie=UTF8&amp;hq=&amp;hnear=Issaquah,+King,+Washington&amp;t=m&amp;ll=47.530184,-122.0327&amp;spn=0.083452,0.205994&amp;z=11&amp;iwloc=A" style="color:#0000FF;text-align:left">View Larger Map</a></small>';
	
	
	/*********************************************************************************************************************
  * output_title()
  *********************************************************************************************************************/
	function output_title()
	{
		$this->tag('title', $this->city . ' Landscaping');
	}
	
	
	/*********************************************************************************************************************
  * output_metas()
  *********************************************************************************************************************/
	function output_metas()
	{
		$desc = str_replace('[city]', $this->city, $this->default_meta_description);
		$keys = str_replace('[city]', $this->city, $this->default_meta_keywords);
		$this->xecho('<meta name="description" content="' . $desc . '" />'); 
		$this->xecho('<meta name="keywords" content="' . $keys . '" />');
	}


	/*********************************************************************************************************************
  * output_heading()
  *********************************************************************************************************************/
	function output_heading()
	{
		$heading = str_replace('[city]', $this->city, $this->heading);
		$this->tag('h1', $heading);
	}
	
	
	/*********************************************************************************************************************
  * output_heading()
  *********************************************************************************************************************/
	function output_services_heading()
	{
		$heading = str_replace('[city]', $this->city, $this->services_heading);
		$this->tag('h2', $heading);
		$this->linktag('services.html', 'See Full List of Landscaping Services...');
		$this->br(2);
	}
	
	
	/*********************************************************************************************************************
  * add_image()
  *********************************************************************************************************************/
	function add_image($file, $caption='')
	{
		$temp = array('file'	=>		$file,
									'caption'	=>	$caption);
		array_push($this->gallery, $temp);
	}
	
	
	/*********************************************************************************************************************
  * output_gallery()
  *********************************************************************************************************************/
	function output_gallery()
	{
		if(!(empty($this->gallery)))
		{
			$this->otag('div', 'minigallery midmargin');
			foreach($this->gallery as $image)
			{
				$this->olink('graphics/landscaping/' . $image['file'], 'lightboximg', '', '', 'title="' . $image['caption'] . '"');
				$this->imgtag('graphics/landscaping/thumbs/' . $image['file']);
				$this->clink();
			}
			$this->ctag();
		}
	}
	
	
	/*********************************************************************************************************************
  * output_services_list()
  *********************************************************************************************************************/
	function output_services_list()
	{
		$this->otag('div', 'roundedgreen rightfloat bigmargin', 'width: 360px;');
		$this->tag('h4', 'Services Provided in ' . $this->city . ' WA');
		$this->otag('ul');
		foreach($this->servicelist as $service)
		{
			$this->tag('li', $service);
		}
		$this->clear();
		$this->ctag(2);	//ul, .roundedgreen
	}
	
	
	/*********************************************************************************************************************
  * output_scheduling()
  *********************************************************************************************************************/
	function output_scheduling()
	{
		$this->olink('contact.php', 'contact_button leftfloat midmargin', '', '', 'alt="Schedule a ' . $this->city . ' Hauling or Landscaping Estimate"');
		$this->tag('div', '');
		$this->clink();
		$this->tag('h2', 'Get a FREE Estimate for your ' . $this->city . ' Landscaping Project');
	}
	
	
	/*********************************************************************************************************************
  * output_citylinks()
  *********************************************************************************************************************/
	function output_citylinks()
	{
		$this->tag('div', $this->mapcode, 'mapcontainer leftfloat', 'margin-right: 50px;');
		$this->tag('h3', 'Other Cities Served Near ' . $this->city . ', WA');
		$this->otag('ul');
		foreach($this->citylist as $thiscity)
		{
			if($thiscity != $this->city)
			{
				$linkurl = strtolower($thiscity);
				$linkurl = str_replace(' ', '-', $linkurl);
				$linkurl = $linkurl . '-' . 'landscaping' . '.php';
				$this->otag('li');
				$this->linktag($linkurl, $thiscity);
				$this->ctag();
			}
			
		}
		$this->ctag();
		$this->clear();
		$this->br();
		$zips = str_replace(' ', '', $this->zipcodes);
		$zips = explode(',', $zips);
		if(is_array($zips))
		{
			$this->otag('div', 'zipbox');
			$this->tag('span', $this->city . ' Zipcodes Served: ');
			$zips = implode('</span> <b>&middot;</b> <span>', $zips);
			$zips = '<span>' . $zips . '</span>';
			$this->xecho($zips);
			$this->clear();
			$this->ctag();	//.zipbox
		}
	}
	
	
}
?>