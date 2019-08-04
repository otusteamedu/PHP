require 'mina/rails'
require 'mina/git'

set :application_name, 'otus'
set :domain, '192.168.1.72'
set :deploy_to, '/home/serv/otus'
set :repository, 'git@github.com:otusteamedu/PHP.git'
set :branch, 'fdor/hw32-1'
set :user, 'serv'

task :deploy do
    deploy do
        invoke :'git:clone'
        invoke :'deploy:link_shared_paths'
        invoke :'deploy:cleanup'

        on :launch do
            in_path(fetch(:current_path)) do
                command %{mkdir -p tmp/}
                command %{touch tmp/restart.txt}
            end
        end
    end
end
