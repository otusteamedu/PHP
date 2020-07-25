# role-based syntax
# ==================

# Defines a role with one or multiple servers. The primary server in each
# group is considered to be the first unless any hosts have the primary
# property set. Specify the username and a domain or IP for the server.
# Don't use `:all`, it's a meta role.

role :app, %w{otus@otus.dev-code.ru}, my_property: :my_value


# Custom SSH Options
# ==================
# You may pass any option but keep in mind that net/ssh understands a
# limited set of options, consult the Net::SSH documentation.
# http://net-ssh.github.io/net-ssh/classes/Net/SSH.html#method-c-start
#
# Global options
# --------------
set :ssh_options, {
    forward_agent: false,
    auth_methods: %w(password)
}

namespace :deploy do
    desc "Check that we can access everything"
    task :check_write_permissions do
        on roles(:all) do |host|
            if test("[ -w #{fetch(:deploy_to)} ]")
                info "#{fetch(:deploy_to)} is writable on #{host}"
            else
                error "#{fetch(:deploy_to)} is not writable on #{host}"
            end
        end
    end

    desc "Check path files list"
    task :check_files_list do
        on roles(:all) do |host|
            execute :ls, "#{deploy_to}"
        end
    end

    before :starting, :ensure_stage do
        on roles(:all) do
            info "...OTUS DEPLOY..."
        end
        invoke "deploy:check_files_list"
    end

    after :updating, :create_release do
        on roles(:all) do
            within release_path do
                info "...Run Composer..."
                execute :composer, "install --no-dev"
            end
        end
    end

    after :updated, :migrate do
        on roles(:all) do
            within release_path do
                info "...Migrations..."
                execute :php, "console/migrator.php"
            end
        end
    end
end
