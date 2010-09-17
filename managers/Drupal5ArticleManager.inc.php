<?php

class Drupal5ArticleManager implements ArticleManagerI
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
		if (is_null($articleID) || !is_numeric($articleID)) { throw new Exception("Parameter articleID is invalid", ArticleManagerException::INVALID_PARAM); }

		// 1b. Load the DB object.
		// NOTE: In true "Tell, Don't Ask" fashion, we don't have to worry at all about
		//       the intricacies of loading the database.
		$DB = MyDB::loadDB();

		// 1c. Attempt to fetch the article from the database.
		$DB->query('SELECT nid AS id, title, created, changed AS lastModified, body FROM node WHERE nid=?', array($articleID));
		$article = $DB->fetchObject('Article');

		if ($article === false)
		{
			throw new ArticleManagerException("Could not find the article.", ArticleManagerException::ARTICLE_NOT_FOUND);
		}

		return $article;
	}

	// 2. Fetch the summaries of x articles, offset by y positions.
	public function fetchArticleSummaries($articleLimit, $offset = 0)
	{
		// 2a. Run sanity checks on the parameters.
		if (is_null($articleLimit) || !is_numeric($articleLimit)) { throw new ArticleManagerException("Parameter articleLimit is invalid.", ArticleManagerException::INVALID_PARAM); }
		if (is_null($offset) || !is_numeric($offset)) { throw new ArticleManagerException("Parameter offset is invalid.", ArticleManagerException::INVALID_PARAM); }

		// 2b. Attempt to fetch the article summaries.
		$DB = MyDB::loadDB();
		$DB->query('SELECT nid AS id, title, created, changed AS lastModified, teaser FROM node ' .
		           'WHERE type="story" AND promote=1 ' .
		           'ORDER BY nid DESC ' . 
		           "LIMIT $offset, $articleLimit");

		$summaries = array();
		while (($article = $DB->fetchObject('Article')))
		{
			$summaries[] = $article;
		}

		return $summaries;
	}

	public function fetchArticleByName($articleName)
	{
	}
}