<?php
session_start();
/****************************************************************************************************
 * file: sendform.php
 * author: chris w.
 * lastrev: 03/21/2012
 * desc: validate and send mike's contact form
 ***************************************************************************************************/
require_once 'includes/class.caPostPage.php';
require_once 'includes/class.ccmailer.php';
require_once 'includes/class.minuser.php';
require_once 'includes/config.regex.php';
require_once 'includes/class.caValidate.php';


$user = new minuser();
$email_to = 'mike@mikeshaulandtractor.com';

$page = new caPostPage('');
$submit = $page->postif('submit');
switch($submit)
{
	case 'Send':
		$val = new caValidate();
		$name = $val->valpost('name', 'name', true);
		$email = $val->valpost('email', 'email', true);
		$phone = $val->valpost('phone', 'phone', true);
		$address = $val->valpost('address', 'street_address', true);
		$city = $val->valpost('city', 'city', true);
		$state = $val->valpost('state', 'state', true);
		$zipcode = $val->valpost('zipcode', 'zipcode', true);
		$subject = $val->valpost('subject', 'alltext64', false);
		$inquiry = $val->longtext_valpost('inquiry', 5000, false);
		if($val->passed())
		{
			$mailer = new ccmailer();
			$mailer->test_mode = false;
			$mailer->to = $email_to;
			$mailer->subject = 'Mikes WebMessage, from ' . $name;
			$mailer->message = "-------------- Field Values ---------------\r\n";
			$mailer->append_field('Send Time (server):', $mailer->print_timestamp());
			$mailer->append_field('Name', $name);
			$mailer->append_field('Email', $email);
			$mailer->append_field('Phone', $phone);
			$mailer->append_field('Address', $address);
			$mailer->append_field('City/State/Zip', $city . ' ' . $state . ' ' . $zipcode);
			$mailer->append_field('Subject', $subject);
			$mailer->append_field('Inquiry', $inquiry, true);
			$mailer->make_safe();
			$result = $mailer->send();
			if($result)
			{
				$page->header_kick('thank-you.html');
			}
			else
			{
				$user->set_message('Sorry, the system was unable to send your message at this time. Please try again or contact us using one of the other contact options listed.', 'error');
				$page->header_kick();
			}
		}
		else
		{
			$user->set_message('Oops! Your message was not sent yet. Please fix the highlighted fields above and click SEND again.', 'error');
			$page->header_kick();
		}
		break;
	default:
		break;
}
$page->header_kick();
?>