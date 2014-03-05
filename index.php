<?php
	/*	HAWKSHAW	Browsererkennung
		Author:		jonas.hess@revier.de
		Licence:	GPLv3	
	*/
	
include 'browser.php';
?>
<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="de-DE"> <![endif]-->
<!--[if IE 7]><html class="no-js lt-ie9 lt-ie8" lang="de-DE"> <![endif]-->
<!--[if IE 8]><html class="no-js lt-ie9" lang="de-DE"> <![endif]-->
<!--[if gt IE 8]><!-->
<html class="no-js" lang="de-DE">
	<!--<![endif]-->
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="css/styles.css" media="all">
		<link rel="shortcut icon" type="image/x-icon" href="icons/favicon.ico" />
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>
		<title>Browsererkennung</title>
		<meta name="viewport" content="width=device-width, minimum-scale=1.0,maximum-scale=1.0">
	</head>
	<body>
		<div id="wrapper">
			<div id="header">
				<div id="logo">
					<a href="#" target="_blank">LOGO</a>
				</div>
			</div>
			<div id="content">

<?php
$browser = new Browser();

if(isset($_POST['senden'])) {
	$mail_to = 'recipient@domain.de';
	$mail_subject = 'Hawkshaw-Browsererkennung: SystemInfo von '.$_POST['name'];
	$mail_message =  'Hallo wertes Kollegium, ' . "\n\n\n";
	$mail_message .= 'da war gerade jemand mit dem Namen "' . $_POST['name'] . '" auf der Browsererkennungseite.' . "\n\n";
	$mail_message .= 'Details zu seinem System:' . "\n\n";
	$mail_message .= 'Browser: ' . "\t\t\t" . $browser->getBrowser() . "\n";
	$mail_message .= 'Version: ' . "\t\t\t" . $browser->getVersion() . "\n";
	if ($browser->isMobile()==true)
	{	
		$mail_message .= 'Mobiles Gerät: ' . "\t\t" . 'Ja' . "\n";
	}
	else
	{
		$mail_message .= 'Mobiles Gerät: ' . "\t\t" . 'Nein' . "\n";	
	}
	$mail_message .= 'Betriebssystem:'          . "\t\t"    .  $browser->getPlatform() . "\n";
	$mail_message .= 'Auflösung Screen(WxH): '  . "\t"      . $_POST['aufloesung_w'] . 'x' . $_POST['aufloesung_h'] . "\n";
	$mail_message .= 'Auflösung Fenster(WxH): ' . "\t"      . $_POST['window_w'] . 'x' . $_POST['window_h'] . "\n";	
	$mail_message .= 'User-Agent: '             . "\t\t\t"  . $_SERVER['HTTP_USER_AGENT'] . "\n\n\n";
	$mail_message .= 'Herzliche Grüße' . "\n";
	$mail_message .= 'Hawkshaw' . "\n";
	$mail_headers  = "Content-type: text/plain; charset=UTF-8 \r\n";
	$mail_headers .= "From: browsererkennung@domain.de\r\n";

	if(mail($mail_to, $mail_subject, $mail_message, $mail_headers)) {
		echo "Vielen Dank.<br />Die Information wurde erfolgreich geschickt.";
	} 
	else {
		echo "Ein Fehler ist aufgetreten.<br />Die Information wurde leider nicht geschickt.";
	}
} 
else {

$mobile = ($browser->isMobile() == true) ?  'Ja' : 'Nein'; 

echo "<h1>Ihre System- und Browserinformationen:</h1>\n";
echo '<div class="label">Browser:</div><div class="value">' . $browser->getBrowser()."</div><div class=\"clear\"></div>\n";
echo '<div class="label">Version:</div><div class="value">' . $browser->getVersion()."</div><div class=\"clear\"></div>\n";
if ($browser->isMobile()==true)
{
	echo '<div class="label">Mobiles Gerät:</div><div class="value">Ja</div><div class="clear"></div>' . "\n";
}
else
{
	echo '<div class="label">Mobiles Gerät:</div><div class="value">Nein</div><div class="clear"></div>' . "\n";
}
echo '<div class="label">Betriebssystem</div><div class="value">' . $browser->getPlatform(). "</div><div class=\"clear\"></div>\n";

echo '<div class="label">Bildschirmauflösung:</div><div class="value"><span id="info_aufloesung_w"></span>';
echo '&nbsp;x&nbsp;';
echo '<span  id="info_aufloesung_h"></span> (<span  id="info_window_w"></span> x <span  id="info_window_h"></span>)</div><div class="clear"></div>' . "\n";
echo '<div class="label">Browserkennung:</div><div class="value">' . $_SERVER['HTTP_USER_AGENT'] . "</div><div class=\"clear\"></div>\n";



?>
		<form id="mform" action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" accept-charset="UTF-8">
		<input type="hidden" name="browser" value="<?php echo $browser->getBrowser() ?>" />
		<input type="hidden" name="version" value="<?php echo $browser->getVersion() ?>" />		
		<input type="hidden" name="betriebssystem" value="<?php echo $browser->getPlatform() ?>" />		
		<input type="hidden" name="browserkennung" value="<?php echo $_SERVER['HTTP_USER_AGENT'] ?>" />		
		<input id="aufloesung_w" type="hidden" name="aufloesung_w" value="" />
		<input id="aufloesung_h" type="hidden" name="aufloesung_h" value="" />
		<input id="window_w" type="hidden" name="window_w" value="" />
		<input id="window_h" type="hidden" name="window_h" value="" />		
<?php
if ($browser -> isMobile() == true) {
	echo '<input type="hidden" name="mobile" value="ja" />' . "\n";
} else {
	echo '<input type="hidden" name="mobile" value="nein" />' . "\n";
}
?>
		<div class="input-wrap input-text">
			<label for="input1" class="label">Ihr Name:</label>
			<input id="input1" class="input-text" type="text" name="name" value="" tabindex="1" /><br/><br/>
		</div>	
		<div class="datenschutz">
		<p>Mit Betätigen des Senden Buttons erkläre ich mich damit einverstanden, dass die o.g. Daten an den Empfänger übermittelt werden.</p>
		</div>
		<div class="input-wrap input-submit">
			<label for="input3" class="label"></label>
			<input id="input3" class="submit" type="submit" name="senden" value="Senden" tabindex="3" />
		</div>
	</form>
<script type="text/javascript">
	function determine() {
		$('#aufloesung_w').val(screen.width);
		$('#window_w').val($(window).width());
		$('#info_aufloesung_w').html(screen.width);
		$('#info_window_w').html($(window).width());
		$('#aufloesung_h').val(screen.height);
		$('#window_h').val($(window).height());
		$('#info_aufloesung_h').html(screen.height);
		$('#info_window_h').html($(window).height());
	}

	$(document).ready(function() {
		determine();
	});

	window.onresize = function() {
		determine();
		if($(window).width() < 1000) {
			$('div#content').width($(window).width() * 1 - 20);
		} else {
			$('div#content').width(1000);
		}

		if($(window).width() < 900) {
			$('div.label').width($(window).width() * 1 - 50);
			$('div.value').width($(window).width() * 0.8);
			$('div.value').css('min-width', '80%');
		} else {
			$('div.label').width('20%');
			$('div.value').css('width', '80%');
			$('div.value').css('min-width', '900');
		}
	}
</script>
<?php }?>
</div>
</div>
</body>
</html>
