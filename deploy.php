<?php

require __DIR__ . '/.deployer/symfony.php';

set('shared_dirs', ['var/logs', 'vendor', 'node_modules']);
set('writable_dirs', ['var/cache', 'var/logs']);

/**
 * Migrate database
 */
task('database:migrate', function () {

    run('php {{release_path}}/' . trim(get('bin_dir'), '/') . '/console doctrine:schema:update --env={{env}} -f -q');

})->desc('Migrate database');

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
    'database:migrate',
    'deploy:cache:warmup',
    'deploy:npm',
    'deploy:symlink',
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
