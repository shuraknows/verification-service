<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230507113338 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add notification table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE notification (
                    id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\',
                    recipient VARCHAR(320) NOT NULL,
                    channel VARCHAR(20) NOT NULL,
                    body LONGTEXT NOT NULL,
                    dispatched TINYINT(1) NOT NULL,
                    PRIMARY KEY(id)
                ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE notification');
    }
}
