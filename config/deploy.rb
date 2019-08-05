require 'mina/rails'
require 'mina/git'

set :application_name, 'otus'
set :domain, '192.168.88.224'
set :deploy_to, '/home/fdor/otus'
set :repository, 'git@github.com:otusteamedu/PHP.git'
set :branch, 'fdor/hw32-1'
set :user, 'fdor'
set :use_sudo, true

task :deploy do
    deploy do
        invoke :'git:clone'
        invoke :'deploy:link_shared_paths'
        invoke :'deploy:cleanup'

        on :launch do
            in_path(fetch(:current_path)) do
                command %{mkdir -p tmp/}
                command %{touch tmp/restart.txt}
                command %{/snap/bin/docker-compose up -d --build}
                command %{/snap/bin/docker exec -it otus-php-fpm bash -c "composer install"}
                command %{/snap/bin/docker exec -it otus-postgres psql -U postgres -c "create user cinema with password 'md56c14da109e294d1e8155be8aa4b1ce8e';"}
                command %{/snap/bin/docker exec -it otus-postgres psql -U postgres -c "create database cinema owner cinema;"}
                command %{/snap/bin/docker exec -it otus-postgres psql -U cinema -c "cinema < src/Db/dql.sql;"}
                command %{/snap/bin/docker exec -it otus-php-fpm bash -c "php src/manager.php"}
            end
        end
    end
end
