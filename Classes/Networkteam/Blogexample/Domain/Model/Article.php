<?php
namespace Networkteam\Blogexample\Domain\Model;

/*                                                                        *
 * This script belongs to the TYPO3 Flow package "Networkteam.Blogexample".*
 *                                                                        *
 *                                                                        */

use TYPO3\Flow\Annotations as Flow;
use Doctrine\ORM\Mapping as ORM;

/**
 * @Flow\Entity
 */
class Article {

	/**
	 * @var string
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=100 })
	 * @Flow\Identity
	 * @ORM\Column(length=100)
	 */
	protected $title;

	/**
	 * @Flow\Identity
	 * @var \DateTime
	 */
	protected $date;

	/**
	 * @var string
	 * @Flow\Validate(type="StringLength", options={ "minimum"=1, "maximum"=50 })
	 * @ORM\Column(length=50)
	 */
	protected $author;

	/**
	 * @var string
	 * @ORM\Column(type="text")
	 * @Flow\Validate(type="Raw")
	 */
	protected $content;

	/**
	 * @ORM\OneToOne(cascade={"persist"})
	 * @var \TYPO3\Media\Domain\Model\Image
	 */
	protected $image;

	/**
	 * Setter for title
	 *
	 * @param string $title
	 * @return void
	 */
	public function setTitle($title) {
		$this->title = $title;
	}

	/**
	 * Getter for title
	 *
	 * @return string
	 */
	public function getTitle() {
		return $this->title;
	}

	/**
	 * Setter for date
	 *
	 * @param \DateTime $date
	 * @return void
	 */
	public function setDate(\DateTime $date) {
		$this->date = $date;
	}

	/**
	 * Getter for date
	 *
	 * @return \DateTime
	 */
	public function getDate() {
		return $this->date;
	}

	/**
	 * Sets the author for this post
	 *
	 * @param string $author
	 * @return void
	 */
	public function setAuthor($author) {
		$this->author = $author;
	}

	/**
	 * Getter for author
	 *
	 * @return string
	 */
	public function getAuthor() {
		return $this->author;
	}

	/**
	 * Sets the content for this post
	 *
	 * @param string $content
	 * @return void
	 */
	public function setContent($content) {
		$this->content = $content;
	}

	/**
	 * Getter for content
	 *
	 * @return string
	 */
	public function getContent() {
		return $this->content;
	}

	/**
	 * @param \TYPO3\Media\Domain\Model\Image $image
	 */
	public function setImage(\TYPO3\Media\Domain\Model\Image $image = NULL) {
		$this->image = $image;
	}

	/**
	 * @return \TYPO3\Media\Domain\Model\Image
	 */
	public function getImage() {
		return $this->image;
	}
}
?>