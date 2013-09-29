#!/bin/sh
openssl aes-256-cbc -d -in src/protected/config/main.php.production.enc -out src/protected/config/main.php
