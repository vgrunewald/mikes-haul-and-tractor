<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/main_template.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<?php
include_once 'includes/class.cahtml.php';
include_once 'includes/class.mikespage.php';
$mpage = new mikespage();
$mpage->city = 'Bellevue';
$mpage->zipcodes = '98004, 98005, 98006, 98007, 98008, 98009, 98015';
$mpage->add_image('bellevue-tractor-services.jpg');
$mpage->add_image('deck-removal-and-hauling.jpg');
$mpage->add_image('home-landscaping-bellevue.jpg');
$mpage->mapcode = '<iframe width="300" height="180" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="http://maps.google.com/maps?f=q&amp;source=s_q&amp;hl=en&amp;geocode=&amp;q=Bellevue,+WA&amp;aq=&amp;sll=47.673988,-122.121512&amp;sspn=0.102873,0.188484&amp;ie=UTF8&amp;hq=&amp;hnear=Bellevue,+King,+Washington&amp;t=m&amp;ll=47.610329,-122.200584&amp;spn=0.041662,0.102654&amp;z=12&amp;iwloc=A&amp;output=embed"></iframe><br /><small><a href="http://maps.google.com/maps?f=q&amp;source=embed&amp;hl=en&amp;geocode=&amp;q=Bellevue,+WA&amp;aq=&amp;sll=47.673988,-122.121512&amp;sspn=0.102873,0.188484&amp;ie=UTF8&amp;hq=&amp;hnear=Bellevue,+King,+Washington&amp;t=m&amp;ll=47.610329,-122.200584&amp;spn=0.041662,0.102654&amp;z=12&amp;iwloc=A" style="color:#0000FF;text-align:left">View Larger Map</a></small>';

$mpage->output_title();
$mpage->output_metas();
?>
<!-- InstanceEndEditable -->
<link rel="stylesheet" href="style/mikesdefault.css" type="text/css" />
<link rel="stylesheet" href="style/sqdrop.css" type="text/css" />
<link rel="stylesheet" href="style/jquery.lightbox-0.5-npmod-black.css" />
<script src="js/jquery-1.6.2.min.js" type="text/javascript"></script>
<script src="js/jquery.dropdownPlain.js" type="text/javascript"></script>
<script src="js/jquery.lightbox-0.5-npmod-black-min.js" type="text/javascript"></script>
<script type="text/javascript">
$(function() {
	$('a.lightboximg').lightBox({fixedNavigation:true});
});
</script>
<!-- InstanceBeginEditable name="head" -->
<!-- InstanceEndEditable -->
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-30082545-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<div class="pagewrapper">
<div class="nonfooter">
<div class="topnav_outer">
<div class="centerpage">

<div class="contact_card">
<div class="free_estimates">FREE Estimates!</div>
<span>Just Call <b>Mike McArthur</b> at:</span>
<h3>(425) 392-6990</h3>
<span>Call anytime before 8:00pm<br />
<b>or</b> <a href="contact.php">Contact Us Online</a></span>
</div><!--div.contact_card-->

<a href="index.html"><img src="graphics/main_logo.png" class="main_logo" /></a>
<img src="graphics/truck-and-tractors.png" class="nav_graphic" />

<div class="navbar">
<ul class="dropdown">
	<li><a href="index.html">Home</a>
</li>
</ul>
<ul class="dropdown">
	<li><a href="services.html"><small>&#x25BC;</small>Services</a>
		<ul class="sub_menu">
            <li><a href="grading.html">Grading</a></li>
            <li><a href="retaining-walls.html">Retaining Walls</a></li>
            <li><a href="earthmoving.html">Earthmoving</a></li>
            <li><a href="mowing.html">Mowing</a></li>
            <li><a href="brush-removal.html">Brush Removal</a></li>
            <li><a href="drainage.html">Drainage</a></li>
            <li><a href="rock-moving.html">Rock Moving</a></li>
            <li><a href="stump-removal.html">Stump Removal</a></li>
            <li><a href="postholes.html">Postholes</a></li>
            <li><a href="rototilling.html">Rototilling</a></li>
            <li><a href="hauling-yard-waste.html">Hauling Sand, Gravel, Soil, etc</a></li>
            <li><a href="asphalt-application-and-removal.html">Asphalt Application &amp; Removal</a></li>
            <li><a href="deck-removal.html">Deck Removal</a></li>
            <li><a href="playground-renovation.html">Playground Renovation</a></li>
            <li><a href="tree-maintenance.html">Tree Maintenance</a></li>
        </ul>
	</li>
</ul>
<ul class="dropdown">
	<li><a href="about.html"><small>&#x25BC;</small>About</a>
		<ul class="sub_menu">
        	<li><a href="service-area.html">Service Area</a></li>
			<li><a href="going-green-landscaping.html">Going Green</a></li>
        </ul>
    </li>
</ul>
<ul class="dropdown">
	<li><a href="faq.html">FAQ</a></li>
</ul>
<ul class="dropdown">
	<li><a href="contact.php">Contact</a></li>
</ul>
<div class="clearer"></div>
</div><!--div.navbar-->

</div><!--div.centerpage-->
</div><!--div.topnav_outer-->

<div class="centerpage maincontent">
<div class="maincontent_inner">
<!-- InstanceBeginEditable name="MainContentRegion" -->
<?php $mpage->output_heading(); ?>



<p>
Need landscaping services for your Bellevue WA home or business? <a href="index.html">Mike's</a> creates attractive, unique, and <a href="going-green-landscaping.html">environmentally friendly</a>
landscaping solutions, with reliable, professional service you can count on.
</p>



<?php
$mpage->output_gallery();
$mpage->output_services_list();
$mpage->br();
$mpage->output_services_heading();
$mpage->br();
?>



<p>
Mike's can improve your yard and garden with services like <a href="grading.html">grading and levelling</a>, <a href="stump-removal.html">stump removal</a>,
<a href="rototilling.html">rototilling</a>, and much more.<br /><br />
I can also help with building needs, such as <a href="retaining-walls.html">retaining walls</a> and <a href="playground-renovation.html">playground renovation</a>,
or <a href="deck-removal.html">tearing down old decks and patios</a> and hauling away the debris.<br /><br />
Don't worry about cleanup - Mike's also <a href="hauling-yard-waste.html">hauls yard waste</a> and debris of all sorts.
</p>



<?php
$mpage->clear();
$mpage->output_scheduling();
?>



<p>
Just call Mike or <a href="contact.php">send a message online</a> today - it only takes a minute, and there's no cost or obligation! I'll come out quickly to
your home or property in Bellevue to provide an assessment and estimate, <b>on location</b>.
</p>



<?php
$mpage->clear();
$mpage->br();
$mpage->stag('hr');
$mpage->br();
$mpage->output_citylinks();
?>

<!-- InstanceEndEditable -->
</div><!--maincontent_inner-->
</div><!--.centerpage maincontent-->

</div><!--.nonfooter-->

<div class="footer">
<div class="centerpage">
<small>Copyright 2016 &copy; Mike's Hauling and Tractor Work</small>
<small><b>Licensed and Bonded# CCBWEX MIKESTO1ODK</b></small>
<a href="policies.html">Website Policies</a>
<a href="contact.php">Contact Mike's</a>
</div><!--.centerpage-->
</div><!--.footer-->

</div><!--.page_wrapper-->
</body>
<!-- InstanceEnd --></html>