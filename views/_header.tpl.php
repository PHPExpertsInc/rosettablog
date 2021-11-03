<?php
/**
* Rosetta Blog
*   Copyright � 2010 Theodore R. Smith <theodore@phpexperts.pro>
* 
* The following code is licensed under a modified BSD License.
* All of the terms and conditions of the BSD License apply with one
* exception:
*
* 1. Every one who has not been a registered student of the "PHPExperts
*    From Beginner To Pro" course (http://www.phpexperts.pro/) is forbidden
*    from modifing this code or using in an another project, either as a
*    deritvative work or stand-alone.
*
* BSD License: http://www.opensource.org/licenses/bsd-license.php
**/

$baseURL = url_a('baseURL');
echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
        <base href="<?php echo $baseURL; ?>"/>
		<title><?php echo $page_title; ?></title>
		<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet' type='text/css'/>
		<link type="text/css" rel="stylesheet" href="css/main.css"/>
<?php
	if (!empty($canonicalURL)) {
?>
		<link rel="canonical" href="<?php echo $canonicalURL; ?>"/>
<?php
	}
	include 'custom/html_head.tpl.php';
?>
	</head>
	<body>
		<div id="header">
			<h1 id="site_title"><?php echo $config['blog_name']; ?></h1>
</div>
<?php
	if (!empty($config['mission'])) {
		// FIXME: Need to make mission statement dynamic again.
		// <h2 class="head" id="mission">< echo $config['mission']; </h2>
?>
			<h2 class="head" id="mission">A needle of <span class="h2em">Hope</span><br />amid a haystack of <span class="h2em">Chaos</span>.</h2>

<?php } ?>
		</div>

