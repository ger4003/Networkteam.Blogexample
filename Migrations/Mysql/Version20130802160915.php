<?php
namespace TYPO3\Flow\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20130802160915 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
			// this up() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("CREATE TABLE networkteam_blogexample_domain_model_article (persistence_object_identifier VARCHAR(40) NOT NULL, image VARCHAR(40) DEFAULT NULL, title VARCHAR(100) NOT NULL, date DATETIME NOT NULL, author VARCHAR(50) NOT NULL, content LONGTEXT NOT NULL, UNIQUE INDEX UNIQ_89219997C53D045F (image), UNIQUE INDEX flow_identity_networkteam_blogexample_domain_model_article (title, date), PRIMARY KEY(persistence_object_identifier))");
		$this->addSql("ALTER TABLE networkteam_blogexample_domain_model_article ADD CONSTRAINT FK_89219997C53D045F FOREIGN KEY (image) REFERENCES typo3_media_domain_model_image (persistence_object_identifier)");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
			// this down() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("DROP TABLE networkteam_blogexample_domain_model_article");
	}
}

?>