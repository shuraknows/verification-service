<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230506183855 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE verification (
                id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\',
                subject_identity VARCHAR(320) NOT NULL,
                subject_identity_type VARCHAR(30) NOT NULL,
                subject_code VARCHAR(8) NOT NULL,
                user_info_ip VARCHAR(45) NOT NULL,
                created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\',
                confirmation_attempt_count INT NOT NULL,
                confirmed TINYINT(1) NOT NULL,
                PRIMARY KEY(id)
            ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE verification');
    }
}
