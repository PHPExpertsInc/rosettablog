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

class Drupal5ArticleEngine implements ArticleEngine
{
	/**
	*  1. Fetch an article based on its ID.
	* 
	* @param int $articleID
	* @return Article
	*/
	public function fetchArticleByID($articleID)
	{
		// 1a. Run sanity checks on $articleID.
		if (is_null($articleID) || !is_numeric($articleID)) { throw new ArticleManagerException("Parameter articleID is invalid", ArticleManagerException::INVALID_PARAM); }

		// 1b. Load the DB object.
		// NOTE: In true "Tell, Don't Ask" fashion, we don't have to worry at all about
		//       the intricacies of loading the database.
		$DB = MyDB::loadDB();

		// 1c. Attempt to fetch the article from the database.
		$DB->query('SELECT nid AS id, title, created AS creationDate, changed AS lastModified, body, format FROM node WHERE nid=? AND status != 0', array($articleID));
		$article = $DB->fetchObject('Article');

		if ($article === false)
		{
			throw new ArticleManagerException("Could not find the article.", ArticleManagerException::ARTICLE_NOT_FOUND);
		}

		return $article;
	}

	// 2. Fetch the summaries of x articles, offset by y positions.
	public function fetchArticleSummaries($articleLimit = 10000000, $offset = 0)
	{
		// 2a. Run sanity checks on the parameters.
		if (is_null($articleLimit) || !is_numeric($articleLimit)) { throw new ArticleManagerException("Parameter articleLimit is invalid.", ArticleManagerException::INVALID_PARAM); }
		if (is_null($offset) || !is_numeric($offset)) { throw new ArticleManagerException("Parameter offset is invalid.", ArticleManagerException::INVALID_PARAM); }

		// 2b. Attempt to fetch the article summaries.
		$DB = MyDB::loadDB();
		$DB->query('SELECT nid AS id, title, created AS creationDate, changed AS lastModified, teaser, format, (teaser = body) teaserEqualsBody FROM node ' .
		           "WHERE type='story' AND promote=1 AND reviewed>0 " .
		           'ORDER BY nid DESC ' . 
		           "LIMIT $offset, $articleLimit");

		$summaries = array();
		while (($article = $DB->fetchObject('Article')))
		{
			if ($article->teaserEqualsBody != true)
			{
				$article->teaser .= sprintf('<br/><a href="%s">[Read more]</a>', url_a("index.php?view=article&id={$article->id}"));
			}
			$summaries[] = $article;
		}

		return $summaries;
	}

	public function fetchArticleByName($articleName)
	{
	}
}
