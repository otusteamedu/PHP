require 'mina/rails'
require 'mina/git'

set :application_name, 'otus-ci'
set :domain, '192.168.1.72'
set :deploy_to, '/home/serv/otus-ci'
set :repository, 'git@github.com:fdor/otus-ci.git'
set :branch, 'master'
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

