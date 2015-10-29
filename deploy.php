<?php

require 'vendor/deployer/deployer/recipe/symfony.php';

set('shared_dirs', ['app/logs', 'vendor', 'node_modules']);

task('deploy:npm', function() {
    run('cd {{release_path}} && ./node_modules/.bin/bower --allow-root install && ./node_modules/.bin/gulp');
});

task('deploy:restart', function() {
    run('/etc/init.d/nginx reload');
    run('/etc/init.d/php5-fpm reload');
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
    'deploy:restart',
    'cleanup',
])->desc('Deploy your project');

set('repository', 'git@github.com:scandesignsdk/scangammon.git');
server('prod', 'scangammon.aarhof.eu', 22)
    ->user('root')
    ->forwardAgent()
    ->stage('production')
    ->env('deploy_path', '/var/www/scangammon.aarhof.eu')
;
