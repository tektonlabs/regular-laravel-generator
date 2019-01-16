@setup
$repoDirName = "/var/www/demos/laravel";
function logMessage($message) {
    return "echo '\033[32m" .$message. "\033[0m';\n";
}
@endsetup

@servers(['server' => ['ladmin@andromeda.tektonlabs.com']])

@story('deploy-code')
git
runComposer
runMigrations
runYarn
generateAssets
cleanCache
finishDeploy
@endstory

@story('deploy-fresh')
git
runComposer
runFreshMigrations
runYarn
generateAssets
cleanCache
finishDeploy
@endstory

@task('git')
{{ logMessage("🏃  Starting deployment...") }}
cd {{ $repoDirName }}
git pull origin {{ $branch }}
@endtask

@task('runComposer')
{{ logMessage("🛠  Running composer...") }}
cd {{ $repoDirName }}
composer install --prefer-dist --no-scripts -q -o;
@endtask

@task('runMigrations')
{{ logMessage("🥦  Running migrations...") }}
cd {{ $repoDirName }}
php artisan migrate --force;
@endtask

@task('runFreshMigrations')
{{ logMessage("🥦  Running fresh migrations...") }}
cd {{ $repoDirName }}
php artisan migrate:fresh --force --seed;
@endtask

@task('cleanCache')
{{ logMessage("✨  Cleaning cache...") }}
cd {{ $repoDirName }}
php artisan clear-compiled;
php artisan config:clear
php artisan cache:clear
php artisan config:cache
php artisan view:cache
@endtask

@task('runYarn')
{{ logMessage("📦  Running Yarn...") }}
cd {{ $repoDirName }}
yarn config set ignore-engines true
yarn --frozen-lockfile
yarn prod
@endtask

@task('generateAssets')
{{ logMessage("🌅  Generating assets...") }}
cd {{ $repoDirName }};
yarn run production --progress false
@endtask

@task('finishDeploy')
{{ logMessage("🍻  Application deployed!") }}
@endtask
