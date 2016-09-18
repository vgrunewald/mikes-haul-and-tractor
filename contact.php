<?php
session_start();
include_once 'includes/class.minuser.php';
$user = new minuser(false);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><!-- InstanceBegin template="/Templates/main_template.dwt" codeOutsideHTMLIsLocked="false" -->
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- InstanceBeginEditable name="doctitle" -->
<title>Contact Mike's Hauling and Tractor</title>
<meta name="description" content="Contact Mikes Hauling and Tractor Work for questions about landscaping, free estimates onsite, or to inquire about hauling and tractor services." />
<meta name="keywords" content="landscaping, estimate, free estimate, quote, landscaping estimate, landscape, landscaper, service, landscaping service, contact, service" />
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
<script src="js/jquery.validate.min.js" type="text/javascript"></script>
<script type="text/javascript">
$(document).ready(function(){
    jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
    phone_number = phone_number.replace(/\s+/g, "");
	return this.optional(element) || phone_number.length > 9 &&
		phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
}, "Please input valid 10-digit phone");

$("#contactform").validate({
  rules: {
    field: {
      required: true,
      phoneUS: true
    }
  }
});
  });
</script>
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
<h1>Contact Mike's Hauling and Tractor</h1>

<div class="leftfloat" style="width: 300px; height: 500px; min-height: 500px; border-right: 1px dotted #000; margin-right: 40px; padding-right: 40px;">
    <p>Thank you for your interest in Mike's landscaping services!</p>
    <h3>Contact Mike McArthur</h3>
    <h4>By phone:</h4>
    <h2 style="text-align: center;">(425)-392-6990</h2>
    <p style="font-style: italic;">7 Days a week, please call before 8:00pm</p>
    <br />
    <h4>Online:</h4>
    <p>Simply complete the form at right for a quick reply.</p>
    <br />
    <h4><a href="about.html#hours-and-location">Hours and Location...</a></h4>
    <br />
    <h4><a href="service-area.html">Service Area (Map)...</a></h4>
</div>


<div class="leftfloat roundedgreen" style="border: 2px outset #9CF;">
<h2>Contact Mike's Online</h2>

<?php
include_once 'includes/class.cahtml.php';
include_once 'includes/class.caform.php';

$form = new caform('sendform.php', 'contactform', 'contactform');
$form->label_element = 'span';

$form->label('* Name:');
$form->add_text('name', '', '', 'required');
$form->tag('small', 'First and Last, ex: "John Smith"');
$form->br(2);

$form->label('* E-Mail:');
$form->add_text('email', '', '', 'email required');
$form->br(2);

$form->label('* Phone:');
$form->add_text('phone', '', '', 'phoneUS required');
$form->tag('small', 'ex: "555-555-5555"');
$form->br(3);

$form->label('* Address:');
$form->add_text('address', '', '', 'xlong required');
$form->br(2);

$form->label('* City:');
$form->add_text('city', '', '', 'required');
$form->br(2);
$form->label('* State:');
$form->add_text('state', '', '', 'xshort required');
$form->tag('small', '2-Letter Abbreviation, ex: "WA"');
$form->br(2);
$form->label('* Zipcode:');
$form->add_text('zipcode', '', '', 'short required');
$form->br(3);

$form->label('Subject:');
$subjects = array('Request FREE Estimate', 'Landscaping Question', 'Tractor Work Question', 'Hauling Question', 'Other');
$form->add_select('subject', $subjects, false, 'Request FREE Estimate');
$form->br(3);

$form->label('Questions, Comments, or Notes:');
$form->clear();
$form->add_textarea('inquiry', 60, 6);
$form->br(3);

$form->add_submit('submit', 'Send');

$form->output();

?>
<div class="clearer"></div>

</div><!--.roundedgreen-->



<div class="clearer"></div>

<br />
<?php $user->dump_message_queue(false); ?>

<br /><br /><br /><br /><br />


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