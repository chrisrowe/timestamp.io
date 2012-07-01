require 'rubygems'
require 'railsless-deploy'

# replace these with your server's information
set :domain,  "buzz"
set :user,    "chrisrowe"

# name this the same thing as the directory on your server
set :application, "timestamp.io"

# use your local repository as the source
set :repository, "file://#{File.expand_path('.')}"

# or use a hosted repository
#set :repository, "ssh://user@example.com/~/git/test.git"

server "#{domain}", :app, :web, :db, :primary => true

set :deploy_via, :copy
set :copy_exclude, [".git", ".DS_Store"]
set :scm, :git
set :branch, "master"
# set this path to be correct on yoru server
set :deploy_to, "/home/#{user}/sites/#{application}"
set :use_sudo, false
set :keep_releases, 2
set :git_shallow_clone, 1

# default_run_options[:pty] = true
ssh_options[:paranoid] = false

# this tells capistrano what to do when you deploy
namespace :deploy do
  desc <<-DESC
  A macro-task that updates the code and fixes the symlink.
  DESC
  task :default do
    transaction do
      update_code
      symlink
    end
  end

  task :update_code, :except => { :no_release => true } do
    on_rollback { run "rm -rf #{release_path}; true" }
    strategy.deploy!
  end

  task :after_deploy do
    cleanup
  end
end

namespace :apache do
	[:stop, :start, :restart, :reload].each do |action|
		desc "#{action.to_s.capitalize} Apache"
		task action, :roles => :web do
			run "sudo service apache2 #{action.to_s}"
		end
	end

	desc "Configure VHost"
	task :addvhost do
		vhost_config =<<-EOF
<VirtualHost *:80>
  # Admin email, Server Name (domain name), and any aliases
  ServerAdmin admin@#{application}
  ServerName  www.#{application}
  ServerAlias #{application}

  # Index file and Document Root (where the public files are located)
  DirectoryIndex index.html index.php
  DocumentRoot /home/chrisrowe/sites/#{application}/current

  # Log file locations
  LogLevel warn
  ErrorLog  /home/chrisrowe/sites/#{application}/logs/error.log
  CustomLog /home/chrisrowe/sites/#{application}/logs/access.log combined
</VirtualHost>
		EOF
		put vhost_config, "/tmp/vhost_config"
		sudo "mv /tmp/vhost_config /etc/apache2/sites-available/#{application}"
    sudo "mkdir /home/chrisrowe/sites/#{application}/logs"
		sudo "a2ensite #{application}"
		run "sudo service apache2 restart"
	end

end