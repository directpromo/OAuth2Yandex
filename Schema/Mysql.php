<?php

namespace Kanboard\Plugin\OAuth2Yandex\Schema;

use PDO;

const VERSION = 1;

function version_1(PDO $pdo)
{
    $pdo->exec('ALTER TABLE users ADD COLUMN oauth2yandex_user_id VARCHAR(255)');
    $pdo->exec('CREATE TABLE oauth2yandex_avatar( email VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, PRIMARY KEY(email))');
}
