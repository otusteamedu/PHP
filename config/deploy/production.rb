# Define roles, user and IP address of deployment server

# role :name, %{[user]@[IP adde.]}

role :app, %w{deployer@192.168.1.44}

server '192.168.1.44', user: 'deployer', roles: %w{app}

# SSH Options
# See the example commented out section in the file
# for more options.

set :ssh_options, {

forward_agent: false,

auth_methods: %w(password),

password: 'user_deployers_password',

user: 'deployer',
}