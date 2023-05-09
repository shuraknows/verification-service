<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230504140323 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create template table';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(
            'CREATE TABLE template (
                id BINARY(16) NOT NULL COMMENT \'(DC2Type:uuid)\',
                slug VARCHAR(30) NOT NULL,
                type VARCHAR(10) NOT NULL,
                content LONGTEXT NOT NULL,                
                PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql('CREATE UNIQUE INDEX UNIQ_97601F83989D9B62 ON template (slug)');
        $this->addSql(
            "INSERT INTO template (id, slug, type, content) 
                    VALUES (0x0187E762D09F752BBD1F18F0D88D9AF6, 'mobile-verification', 'plain', 'Your verification code is {{ code }}.')"
        );
        $this->addSql(
            "INSERT INTO template (id, slug, type, content) 
                    VALUES (0x0187E762D14E7F3DBC4E6427C1B2C676, 'email-verification', 'html', '<!DOCTYPE html>
<html>
<head>
    <title>Email verification</title>
    <style>
        .content {
            margin: auto;
            width: 600px;
        }
    </style>
</head>
<body>
    <div class=\"content\">
        <p>Your verification code is {{ code }}.</p>
    </div>
</body>
</html>
');"
        );
    }
    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE template');
    }
}
