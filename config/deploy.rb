# config valid for current version and patch releases of Capistrano
lock "~> 3.14.1"

set :application, "db_random_str"
set :repo_url, "https://github.com/azat-nizam/db_random_str.git"

# Default branch is :master
# ask :branch, `git rev-parse --abbrev-ref HEAD`.chomp

# Default deploy_to directory is /var/www/my_app_name
set :deploy_to, "/home/otus/web/otus.dev-code.ru"

# Default value for :linked_files is []
append :linked_files, "config.yml"

# Default value for linked_dirs is []
append :linked_dirs, "document_errors"

# Default value for keep_releases is 5
set :keep_releases, 3
