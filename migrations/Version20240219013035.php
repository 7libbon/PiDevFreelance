<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240219013035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY pk_cv');
        $this->addSql('CREATE TABLE commande (id INT AUTO_INCREMENT NOT NULL, service_id INT DEFAULT NULL, user_id INT DEFAULT NULL, date DATE NOT NULL, statut VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_6EEAA67DED5CA9E6 (service_id), INDEX IDX_6EEAA67DA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre (id INT AUTO_INCREMENT NOT NULL, id_user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, echances DATE NOT NULL, statut VARCHAR(255) NOT NULL, prix DOUBLE PRECISION NOT NULL, INDEX IDX_AF86866F79F37AE5 (id_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, disponibilite VARCHAR(255) NOT NULL, categorie VARCHAR(255) NOT NULL, INDEX IDX_E19D9AD2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F79F37AE5 FOREIGN KEY (id_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE tache DROP FOREIGN KEY pk_projet');
        $this->addSql('DROP TABLE cv');
        $this->addSql('DROP TABLE projet');
        $this->addSql('DROP TABLE tache');
        $this->addSql('ALTER TABLE choix MODIFY id_choix INT NOT NULL');
        $this->addSql('ALTER TABLE choix DROP FOREIGN KEY pk_question');
        $this->addSql('DROP INDEX pk_question ON choix');
        $this->addSql('DROP INDEX `primary` ON choix');
        $this->addSql('ALTER TABLE choix ADD id_question_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, DROP id_question, CHANGE id_choix id INT AUTO_INCREMENT NOT NULL, CHANGE reponse_q rep_q VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE choix ADD CONSTRAINT FK_4F4880916353B48 FOREIGN KEY (id_question_id) REFERENCES question (id)');
        $this->addSql('ALTER TABLE choix ADD CONSTRAINT FK_4F488091A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_4F4880916353B48 ON choix (id_question_id)');
        $this->addSql('CREATE INDEX IDX_4F488091A76ED395 ON choix (user_id)');
        $this->addSql('ALTER TABLE choix ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE cours MODIFY id_cours INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON cours');
        $this->addSql('ALTER TABLE cours ADD user_id INT DEFAULT NULL, CHANGE categorie categorie VARCHAR(255) NOT NULL, CHANGE id_cours id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD CONSTRAINT FK_FDCA8C9CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FDCA8C9CA76ED395 ON cours (user_id)');
        $this->addSql('ALTER TABLE cours ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE demande MODIFY id_demande INT NOT NULL');
        $this->addSql('DROP INDEX pk_cv ON demande');
        $this->addSql('DROP INDEX `primary` ON demande');
        $this->addSql('ALTER TABLE demande ADD offre_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, DROP id_cv, DROP prix, DROP delais, CHANGE id_demande id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A54CC8505A FOREIGN KEY (offre_id) REFERENCES offre (id)');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_2694D7A54CC8505A ON demande (offre_id)');
        $this->addSql('CREATE INDEX IDX_2694D7A5A76ED395 ON demande (user_id)');
        $this->addSql('ALTER TABLE demande ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE question MODIFY id_question INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON question');
        $this->addSql('ALTER TABLE question ADD user_id INT DEFAULT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE id_question id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE question ADD CONSTRAINT FK_B6F7494EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_B6F7494EA76ED395 ON question (user_id)');
        $this->addSql('ALTER TABLE question ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE reclamation MODIFY id_reclamation INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON reclamation');
        $this->addSql('ALTER TABLE reclamation ADD user_id INT DEFAULT NULL, CHANGE id_reclamation id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_CE606404A76ED395 ON reclamation (user_id)');
        $this->addSql('ALTER TABLE reclamation ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE reponse MODIFY id_reponse INT NOT NULL');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY pk_reclamation');
        $this->addSql('DROP INDEX pk_reclamation ON reponse');
        $this->addSql('DROP INDEX `primary` ON reponse');
        $this->addSql('ALTER TABLE reponse ADD reclamation_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, DROP id_reclamation, CHANGE id_reponse id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC72D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT FK_5FB6DEC7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5FB6DEC72D6BA2D9 ON reponse (reclamation_id)');
        $this->addSql('CREATE INDEX IDX_5FB6DEC7A76ED395 ON reponse (user_id)');
        $this->addSql('ALTER TABLE reponse ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE reservation MODIFY id_reservation INT NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY pk_cours');
        $this->addSql('DROP INDEX pk_cours ON reservation');
        $this->addSql('DROP INDEX `primary` ON reservation');
        $this->addSql('ALTER TABLE reservation ADD cours_id INT DEFAULT NULL, ADD user_id INT DEFAULT NULL, ADD commantaire VARCHAR(255) NOT NULL, DROP id_cours, DROP nomF, DROP prenomF, DROP adrEmail, DROP commentaire, CHANGE id_reservation id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C849557ECF78B0 FOREIGN KEY (cours_id) REFERENCES cours (id)');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT FK_42C84955A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_42C849557ECF78B0 ON reservation (cours_id)');
        $this->addSql('CREATE INDEX IDX_42C84955A76ED395 ON reservation (user_id)');
        $this->addSql('ALTER TABLE reservation ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE user MODIFY cin INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON user');
        $this->addSql('ALTER TABLE user CHANGE prenom prenom VARCHAR(255) NOT NULL, CHANGE sexe sexe VARCHAR(255) NOT NULL, CHANGE num_tel num_tel VARCHAR(255) NOT NULL, CHANGE cin id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A54CC8505A');
        $this->addSql('CREATE TABLE cv (id_cv INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prenom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adr VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, num_tel INT NOT NULL, objectif VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, competences VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_cv)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE projet (id_projet INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_d DATE NOT NULL, date_f DATE NOT NULL, prix INT NOT NULL, statut VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, echéances VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id_projet)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE tache (id_tache INT AUTO_INCREMENT NOT NULL, id_projet INT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date_d DATE NOT NULL, date_f DATE NOT NULL, prix INT NOT NULL, INDEX pk_projet (id_projet), PRIMARY KEY(id_tache)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE tache ADD CONSTRAINT pk_projet FOREIGN KEY (id_projet) REFERENCES projet (id_projet) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DED5CA9E6');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DA76ED395');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F79F37AE5');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A76ED395');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE offre');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('ALTER TABLE choix MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE choix DROP FOREIGN KEY FK_4F4880916353B48');
        $this->addSql('ALTER TABLE choix DROP FOREIGN KEY FK_4F488091A76ED395');
        $this->addSql('DROP INDEX IDX_4F4880916353B48 ON choix');
        $this->addSql('DROP INDEX IDX_4F488091A76ED395 ON choix');
        $this->addSql('DROP INDEX `PRIMARY` ON choix');
        $this->addSql('ALTER TABLE choix ADD id_question INT NOT NULL, DROP id_question_id, DROP user_id, CHANGE id id_choix INT AUTO_INCREMENT NOT NULL, CHANGE rep_q reponse_q VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE choix ADD CONSTRAINT pk_question FOREIGN KEY (id_question) REFERENCES question (id_question) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX pk_question ON choix (id_question)');
        $this->addSql('ALTER TABLE choix ADD PRIMARY KEY (id_choix)');
        $this->addSql('ALTER TABLE cours MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE cours DROP FOREIGN KEY FK_FDCA8C9CA76ED395');
        $this->addSql('DROP INDEX IDX_FDCA8C9CA76ED395 ON cours');
        $this->addSql('DROP INDEX `PRIMARY` ON cours');
        $this->addSql('ALTER TABLE cours DROP user_id, CHANGE categorie categorie INT NOT NULL, CHANGE id id_cours INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE cours ADD PRIMARY KEY (id_cours)');
        $this->addSql('ALTER TABLE demande MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5A76ED395');
        $this->addSql('DROP INDEX IDX_2694D7A54CC8505A ON demande');
        $this->addSql('DROP INDEX IDX_2694D7A5A76ED395 ON demande');
        $this->addSql('DROP INDEX `PRIMARY` ON demande');
        $this->addSql('ALTER TABLE demande ADD id_cv INT NOT NULL, ADD prix INT NOT NULL, ADD delais VARCHAR(255) NOT NULL, DROP offre_id, DROP user_id, CHANGE id id_demande INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT pk_cv FOREIGN KEY (id_cv) REFERENCES cv (id_cv) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX pk_cv ON demande (id_cv)');
        $this->addSql('ALTER TABLE demande ADD PRIMARY KEY (id_demande)');
        $this->addSql('ALTER TABLE question MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE question DROP FOREIGN KEY FK_B6F7494EA76ED395');
        $this->addSql('DROP INDEX IDX_B6F7494EA76ED395 ON question');
        $this->addSql('DROP INDEX `PRIMARY` ON question');
        $this->addSql('ALTER TABLE question DROP user_id, CHANGE description description INT NOT NULL, CHANGE id id_question INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE question ADD PRIMARY KEY (id_question)');
        $this->addSql('ALTER TABLE reclamation MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404A76ED395');
        $this->addSql('DROP INDEX IDX_CE606404A76ED395 ON reclamation');
        $this->addSql('DROP INDEX `PRIMARY` ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP user_id, CHANGE id id_reclamation INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD PRIMARY KEY (id_reclamation)');
        $this->addSql('ALTER TABLE reponse MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC72D6BA2D9');
        $this->addSql('ALTER TABLE reponse DROP FOREIGN KEY FK_5FB6DEC7A76ED395');
        $this->addSql('DROP INDEX UNIQ_5FB6DEC72D6BA2D9 ON reponse');
        $this->addSql('DROP INDEX IDX_5FB6DEC7A76ED395 ON reponse');
        $this->addSql('DROP INDEX `PRIMARY` ON reponse');
        $this->addSql('ALTER TABLE reponse ADD id_reclamation INT NOT NULL, DROP reclamation_id, DROP user_id, CHANGE id id_reponse INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE reponse ADD CONSTRAINT pk_reclamation FOREIGN KEY (id_reclamation) REFERENCES reclamation (id_reclamation) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX pk_reclamation ON reponse (id_reclamation)');
        $this->addSql('ALTER TABLE reponse ADD PRIMARY KEY (id_reponse)');
        $this->addSql('ALTER TABLE reservation MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C849557ECF78B0');
        $this->addSql('ALTER TABLE reservation DROP FOREIGN KEY FK_42C84955A76ED395');
        $this->addSql('DROP INDEX IDX_42C849557ECF78B0 ON reservation');
        $this->addSql('DROP INDEX IDX_42C84955A76ED395 ON reservation');
        $this->addSql('DROP INDEX `PRIMARY` ON reservation');
        $this->addSql('ALTER TABLE reservation ADD id_cours INT NOT NULL, ADD prenomF VARCHAR(255) NOT NULL, ADD adrEmail VARCHAR(255) NOT NULL, ADD commentaire TEXT NOT NULL, DROP cours_id, DROP user_id, CHANGE id id_reservation INT AUTO_INCREMENT NOT NULL, CHANGE commantaire nomF VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE reservation ADD CONSTRAINT pk_cours FOREIGN KEY (id_cours) REFERENCES cours (id_cours) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX pk_cours ON reservation (id_cours)');
        $this->addSql('ALTER TABLE reservation ADD PRIMARY KEY (id_reservation)');
        $this->addSql('ALTER TABLE user MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON user');
        $this->addSql('ALTER TABLE user CHANGE prenom prenom INT NOT NULL, CHANGE sexe sexe INT NOT NULL, CHANGE num_tel num_tel INT NOT NULL, CHANGE id cin INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE user ADD PRIMARY KEY (cin)');
    }
}
