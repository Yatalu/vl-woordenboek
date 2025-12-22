<?php
/**
 * LARAVEL ENVOY INFRASTRUCTURE GUIDE
 * * This script automates deployment and maintenance for the 'vl-woordenboek' application.
 * * PREREQUISITES:
 * 1. Local: 'composer global require laravel/envoy'
 * 2. Local: A '.env' file containing SSH_SERVER and SSH_USER.
 * 3. Remote: SSH Key access and Composer/PHP installed.
 * * EXECUTION:
 * envoy run [task_name]
 */
?>

@setup
    /**
     * LOCAL CONFIGURATION
     * This block runs on the local machine to prepare the environment.
     */
    require __DIR__.'/vendor/autoload.php';
    
    // Load credentials from local .env to avoid hardcoding secrets
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
    $dotenv->load();

    // Configuration Variables
    $branch = 'v2.x-dev';           // The target git branch for deployment
    $server = env('SSH_SERVER');     // Remote server IP/Hostname
    $user = env('SSH_USER');         // SSH Username
    $applicationDir = 'vl-woordenboek'; // Target directory on the remote server
    
    $userAndServer = $user .'@'. $server;

    /**
     * Helper: Returns a Bash echo command with green ANSI color coding
     */
    function logMessage($message) {
        return "echo '\033[32m" .$message. "\033[0m';\n";
    }
@endsetup

@servers(['remote' => $userAndServer])

/**
 * TASK: composer:update
 * Use case: Manually refreshing dependencies on the remote server.
 * Warning: This will modify the composer.lock file if run in a dev environment.
 */
@task('composer:update')
    echo 'Update dependencies';
    composer update
@endtask

/**
 * TASK: composer:audit
 * Use case: Security & Maintenance checks.
 * 
 * Actions: 
 * 1. Scans installed packages for known vulnerabilities.
 * 2. Lists packages that have newer versions available.
 */
@task('composer:audit')
    cd {{ $applicationDir }}
    echo "--- Running Composer Audit ---"
    composer audit
    echo "--- Checking for Outdated Packages ---"
    composer outdated --direct
@endtask

/**
 * TASK: deploy:only-code
 * Use case: Standard deployment of the v2.x-dev branch.
 *
 * INFRASTRUCTURE IMPACT:
 * 1. Maintenance Mode: The site will show a maintenance page to users.
 * 2. Git Pull: Updates code from the remote repository.
 * 3. Optimization: Rebuilds Laravel's internal config/route caches.
 */
@task('deploy:only-code')
    {{ logMessage("Starting Deployment...") }}
    cd {{ $applicationDir }}

    {{ logMessage("Fetching latest code from $branch...") }}
    git pull origin {{ $branch }}

    {{ logMessage("Entering Maintenance Mode...") }}
    php artisan down --render="errors.maintenance"

    {{ logMessage("Synchronizing dependencies...") }}
    composer update

    {{ logMessage("Rebuilding Application Cache...") }}
    php artisan optimize

    {{ logMessage("Application is now LIVE.") }}
    php artisan up
@endtask