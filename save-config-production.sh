#!/bin/sh
openssl aes-256-cbc -in src/protected/config/main.php -out src/protected/config/main.php.production.enc

