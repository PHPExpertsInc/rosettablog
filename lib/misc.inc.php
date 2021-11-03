<?php
/**
* Rosetta Blog
*   Copyright © 2010 Theodore R. Smith <theodore@phpexperts.pro>
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


/**
 * Simply converts new lines to XHTML <p>.
 * @param string $text
 * @return string
 */
function nl2p($text)
{
    $new_text = '<p>' . preg_replace('/\r?\n\r?\n/', "</p><p>", $text) . '</p>';
    $new_text = str_replace("\n", "<br/>\n", $new_text);

    return $new_text;
}

function url_a($url_in, $noEscaping = false)
{
	// See if URLFactory can handle it directly...
	if (($url = URLFactory::makePrettyURL($url_in)) != false)
	{
		return $url;
	}

    $config = SimpleConfig::getInstance();
    $parts = parse_url($url_in);

    if (isset($parts['host']) || $config['pretty_urls'] === false)
    {
        return !$noEscaping ? htmlentities($url_in) : $url_in;
    }

    // At this point, we can safely assume that pretty_urls is enabled.
    $args = array();
    parse_str($parts['query'], $args);

    $url = URLFactory::makePrettyURL($args);

    return $url;
}
