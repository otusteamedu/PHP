# !! When editing the file (or defining the configurations),
#    you can either comment them out or add the new lines.
#    Make sure to **not** to have some example settings
#    overriding the ones you are appending.
# Define the name of the application

set :application, "hw32"

set :repo_url, "https://github.com/otusteamedu/PHP.git"

set :branch, fetch(:branch, "nvggit/hw23")

set :env, fetch(:env, "production")

set :scm, :git

set :deploy_to, "/var/www/hw23"

set :pty, true

set :format, :pretty
