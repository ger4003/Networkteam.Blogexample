<?php
namespace Networkteam\Blogexample\View\Article;

use TYPO3\Flow\Annotations as Flow;

/**
 * Class CustomJson
 *
 * @package Networkteam\Blogexample\View\Article
 */
class CustomJson extends \TYPO3\Flow\Mvc\View\AbstractView {

	/**
	 * @var \TYPO3\Flow\Resource\Publishing\ResourcePublisher
	 * @Flow\Inject
	 */
	protected $resourcePublisher;

	/**
	 * @return string
	 */
	public function render() {
		$data = array(
			'changed' => FALSE,
			'timestamp' => time(),
			'articles' => array()
		);

		// set Content-Type header
		$this->controllerContext->getResponse()->setHeader('Content-Type', 'application/json');

		// get variables from controller action
		$articles = $this->variables['articles'];

		foreach($articles as $article) {
			$data['articles'][] = $this->articleToArray($article, 150, 150);
		}

		return json_encode($data);
	}

	/**
	 * @param \Networkteam\Blogexample\Domain\Model\Article $article
	 * @param integer $imgMaxWidth
	 * @param integer $imgMaxHeight
	 * return array
	 */
	protected function articleToArray(\Networkteam\Blogexample\Domain\Model\Article $article,  $imgMaxWidth = NULL, $imgMaxHeight = NULL) {
		$imgUrl = '';
		$articleImage = $article->getImage();

		// scale image to given maxWith and maxHeight and resulting ratio
		if ($articleImage) {
			$imgWidth = $articleImage->getWidth() > $imgMaxWidth ? $imgMaxWidth : $articleImage->getWidth();
			$imgHeight = $imgWidth * ($imgMaxHeight / $imgMaxWidth);
			$imgUrl = $this->resourcePublisher->getPersistentResourceWebUri($articleImage->getThumbnail($imgWidth, $imgHeight, $articleImage::RATIOMODE_OUTBOUND)->getResource());
		}

		return array(
			'title' => $article->getTitle(),
			'date' => $article->getDate(),
			'author' => $article->getAuthor(),
			'content' => $article->getContent(),
			'imgUrl' => $imgUrl
		);
	}
}