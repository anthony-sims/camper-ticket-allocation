<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:anthony-sims/camper-ticket-allocation.git');

add('shared_files', []);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('139.180.146.120')
    ->set('remote_user', 'manager')
    ->set('http_user', 'manager')
    ->set('deploy_path', '~/cob_tickets');

// Hooks

after('deploy:failed', 'deploy:unlock');
