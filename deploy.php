<?php

namespace Deployer;

require 'vendor/jalogut/magento2-deployer-plus/recipe/magento_2_2_5.php';

// Use timestamp for release name
set('release_name', function () {
    return date('YmdHis');
});

// Magento dir into the project root. Set "." if magento is installed on project root
set('magento_dir', 'magento');
// [Optional] Git repository. Only needed if not using build + artifact strategy
set('repository', '');
// Space separated list of languages for static-content:deploy
set('languages', 'en_US');
// Enable all caches after deployment
set('cache_enabled_caches', 'all');

// OPcache configuration
task('cache:clear:opcache', 'sudo systemctl reload php-fpm');
after('cache:clear', 'cache:clear:opcache');

// Build host
localhost('build');

// Remote Servers
host('master')
    ->hostname('<hostname>')
    ->user('<user>')
    ->set('deploy_path', '/var/www/html/')
    ->stage('dev')
    ->roles('master');
