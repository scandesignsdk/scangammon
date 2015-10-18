<?php

require 'vendor/deployer/deployer/recipe/symfony.php';

set('shared_dirs', ['app/logs', 'vendor', 'node_modules']);

task('deploy:npm', function() {
    run('cd {{release_path}} && ./node_modules/.bin/bower --allow-root install && ./node_modules/.bin/gulp');
});

task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:create_cache_dir',
    'deploy:shared',
    'deploy:writable',
    'deploy:assets',
    'deploy:vendors',
    'deploy:cache:warmup',
    'deploy:symlink',
    'deploy:npm',
    'cleanup',
])->desc('Deploy your project');

set('repository', 'git@gitlab.com:lsv/backgammon.git');
server('prod', 'picks.aarhof.eu', 22)
    ->user('root')
    ->forwardAgent()
    ->stage('production')
    ->env('deploy_path', '/var/www/scangammon.aarhof.eu')
;
