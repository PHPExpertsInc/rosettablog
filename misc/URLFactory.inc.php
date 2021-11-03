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

class URLFactory
{
    private function __construct() { }

    private static function make()
    {
        $config = SimpleConfig::getInstance();
        
        if (isset($config['url_style']))
        {
            $className = $config['url_style'] . 'URLScheme';

            if (class_exists($className))
            {
                return new $className;
            }
        }
        
        return new RosettaURLScheme;
    }

    public static function makePrettyURL($args)
    {
        $url = self::make();

        return $url->makePrettyURL($args);
    }
}

interface URLSchemeI
{
	public function makePrettyURL($params);
}

// FIXME?? This may be much better as a Strategy Pattern.
class CommonURLScheme implements URLSchemeI
{
	protected $baseURL;

	public function getBaseURL()
	{
		if ($this->baseURL !== null) { return $this->baseURL; }

		$protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
		$domain = $_SERVER['HTTP_HOST'];
		if (substr_count($_SERVER['SCRIPT_NAME'], '/') === 1)
		{
			$baseURL = sprintf("%s://%s/", $protocol, $domain);
		}
		else
		{
			$basePath = substr($_SERVER['SCRIPT_NAME'], 1, strrpos($_SERVER['SCRIPT_NAME'], '/') - 1);
			$baseURL = sprintf("%s://%s/%s/", $protocol, $domain, $basePath);
		}

		$this->baseURL = $baseURL;

		return $baseURL;
	}

	public function makePrettyURL($params)
	{
		if ($params == 'baseURL')
		{
			return $this->getBaseURL();
		}
	}
}

class RosettaURLScheme extends CommonURLScheme implements URLSchemeI
{
    public function makePrettyURL($params)
    {
        if (isset($params['view']) && $params['view'] == 'article')
        {
            $url = $this->getBaseURL() . 'article/' . $params['id'];
            unset($params['view']); unset($params['id']);

            if (!empty($params))
            {
                // Append the rest of the array:
                $url .= '?' . http_build_query($params);
            }
        }

        return $url;
    }
}

class DrupalURLScheme extends CommonURLScheme implements URLSchemeI
{
    public function makePrettyURL($params)
    {
		$url = parent::makePrettyURL($params);

        if (isset($params['view']) && $params['view'] == 'article')
        {
            $url = $this->getBaseURL() . 'node/' . $params['id'];
            unset($params['view']); unset($params['id']);

            if (!empty($params))
            {
                // Append the rest of the array:
                $url .= '?' . http_build_query($params);
            }
        }

        return $url;
    }
}

