# Set the name of our app and the domain to deploy to
set :application, "timestamp.io"
set :domain, "timestamp.io"

# The directory to deploy to. Set your web server to point at
# /var/www/myApp/current
set :deploy_to, "~chrisrowe/sites/timestamp.io" 

# Tell capistrano to use git and describe our repository
set :scm, :git
set :repository, "git@github.com:chrisrowe/timestamp.io.git"  # Your repo
set :branch, "master" # Deploy from branch master
set :git_enable_submodules, 1 # Set this if you are using submodules

# Keep a git repo on our server to avoid cloning for every deploy
set :deploy_via, :remote_cache 

# Specify the user used to deploy on the server
set :user, "chrisrowe"
set :use_sudo, false

# Our web & db servers are both at the domain we specified earlier
role :web, domain 
role :db,  domain, :primary => true # Migrations run here

# Keep 3 previous releases on the server
set :keep_releases, 3