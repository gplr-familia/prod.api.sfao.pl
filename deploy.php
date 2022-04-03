<?php
namespace Deployer;

require 'recipe/symfony3.php';

// Project name
set('application', 'my-doctor-api');

// Project repository
set('repository', 'git@bitbucket.org:mayahG/my-doctor-api.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', []);
add('shared_dirs', []);

// Writable dirs by web server 
add('writable_dirs', ['web/public/media']);

// Hosts

host('sfao.tomasz.p5.tiktalik.io')
    ->user('deploy')
    ->set('deploy_path', '~/{{application}}');

//host('sfao.tomasz.p4.tiktalik.io')
//    ->user('deploy')
//    ->stage('dev')
//    ->set('deploy_path', '~/{{application}}-dev')
//    ->set('env', ['SYMFONY_ENV' => 'dev'])
//    ->set('composer_options', '{{composer_action}} --verbose --prefer-dist --no-progress --no-interaction --optimize-autoloader');

/**
 * Migrate database
 */
task('database:migrate', function () {
    run('{{bin/php}} {{bin/console}} doctrine:schema:update {{console_options}} --force');
})->desc('Migrate database');
    
// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');

// Migrate database before symlink new release.

before('deploy:symlink', 'database:migrate');

