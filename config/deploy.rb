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
            end
        end
    end
end
