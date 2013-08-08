<?php
namespace Networkteam\Blogexample\Controller;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Networkteam.Blogexample".*
 *                                                                        *
 *                                                                        */

use Networkteam\Blogexample\Domain\Model\Article;
use Networkteam\Blogexample\Domain\Repository\ArticleRepository;
use TYPO3\Flow\Annotations as Flow;

class ArticleController extends \TYPO3\Flow\Mvc\Controller\ActionController {

	/**
	 * @Flow\Inject
	 * @var \Networkteam\Blogexample\Domain\Repository\ArticleRepository
	 */
	protected $articleRepository;

	/**
	 * @var \TYPO3\Flow\Resource\Publishing\ResourcePublisher
	 * @Flow\Inject
	 */
	protected $resourcePublisher;

	/**
	 * @var array
	 */
	protected $viewFormatToObjectNameMap = array('json' => 'TYPO3\Flow\Mvc\View\JsonView');

	/**
	 * list articles for json and html
	 */
	public function indexAction() {
		$format = $this->getControllerContext()->getRequest()->getFormat();
		$articles = $this->articleRepository->findAll();

		switch ($format) {
			case 'json':
				// set urls for image thumbnails of each article
				foreach($articles as $article) {
					$imgUrl = '';
					$imgMaxWidth = $imgMaxHeight = 150;
					$articleImage = $article->getImage();

					// scale image to given maxWith and maxHeight and resulting ratio
					if ($articleImage) {
						$imgWidth = $articleImage->getWidth() > $imgMaxWidth ? $imgMaxWidth : $articleImage->getWidth();
						$imgHeight = $imgWidth * ($imgMaxHeight / $imgMaxWidth);
						$imgUrl = $this->resourcePublisher->getPersistentResourceWebUri($articleImage->getThumbnail($imgWidth, $imgHeight, $articleImage::RATIOMODE_OUTBOUND)->getResource());
					}

					$customArticles[] = array(
						'title' => $article->getTitle(),
						'date' => $article->getDate(),
						'author' => $article->getAuthor(),
						'content' => $article->getContent(),
						'image' => $articleImage,
						'imgUrl' => $imgUrl
					);
				}

				// set vars for use in json view
				$this->view->assignMultiple(array(
					'changed' => FALSE,
					'timestamp' => time(),
					'articles' => $customArticles
				));

				// set variables to render. By default only the variable 'value' will be rendered
				$this->view->setVariablesToRender(array('changed', 'timestamp', 'articles'));

				// configure the json view
				$this->view->setConfiguration(array(
					'articles' => array(
						'_descendAll' => array(
							'_exclude' => array('image')
						)
					)
				));
				break;

			case 'html':
				// configure the html view here
				$this->view->assign('articles', $articles);
				break;
		}
	}

	/**
	 * list articles
	 */
	public function customAction() {
		$articles = $this->articleRepository->findAll();
		$this->view->assign('articles', $articles);
	}
}

?>