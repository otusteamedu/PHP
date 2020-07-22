# server-based syntax
# ======================
# Defines a single server with a list of roles and multiple properties.
# You can define all roles on a single server, or split them:

# server "example.com", user: "deploy", roles: %w{app db web}, my_property: :my_value
# server "example.com", user: "deploy", roles: %w{app web}, other_property: :other_value
# server "db.example.com", user: "deploy", roles: %w{db}



# role-based syntax
# ==================

# Defines a role with one or multiple servers. The primary server in each
# group is considered to be the first unless any hosts have the primary
# property set. Specify the username and a domain or IP for the server.
# Don't use `:all`, it's a meta role.

role :app, %w{otus@otus.dev-code.ru}, my_property: :my_value
# role :web, %w{user1@primary.com user2@additional.com}, other_property: :other_value
# role :db,  %w{deploy@example.com}



# Configuration
# =============
# You can set any configuration variable like in config/deploy.rb
# These variables are then only loaded and set in this stage.
# For available Capistrano configuration variables see the documentation page.
# http://capistranorb.com/documentation/getting-started/configuration/
# Feel free to add new variables to customise your setup.



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
#
# The server-based syntax can be used to override options:
# ------------------------------------
# server "otus.dev-code.ru",
#   user: "otus",
#   roles: %w{web app},
#   ssh_options: {
#     user: "otus", # overrides user setting above
#     keys: %w(/home/user_name/.ssh/id_rsa),
#     forward_agent: false,
#     auth_methods: %w(publickey password)
#     # password: "please use keys"
#   }

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
end
