<?php

require 'vendor/deployer/deployer/recipe/symfony.php';

set('repository', 'git@gitlab.com:lsv/backgammon.git');
server('prod', 'picks.aarhof.eu', 22)
    ->user('root')
    ->forwardAgent()
    ->stage('production')
    ->env('deploy_path', '/var/www/scangammon.aarhof.eu')
;
