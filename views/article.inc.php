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
$articleURL = url_a("index.php?view=article&id={$article_id}");
$canonicalURL = isset($canonicalURL)
                ? $canonicalURL
                : $articleURL;
?>
<?php require '_header.tpl.php'; ?>
		<div class="article_box">
			<h2><a href="<?php echo $articleURL; ?>"><?php echo $article_title; ?></a></h2>
			<table class="date_box">
				<tr>
					<td>Created: <?php echo $creation_date; ?></td>
                                    <?php if ($last_modified != $creation_date) { ?>
					<td>Last modified: <?php echo $last_modified; ?></td>
                                    <?php } ?>
				</tr>
			</table>
			<div class="article_body"><?php echo $main_content; ?></div>
		</div>
<?php require '_footer.tpl.php'; ?>
