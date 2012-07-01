require 'rubygems'
require 'railsless-deploy'

set :domain,  "buzz"
set :user,    "chrisrowe"
set :application, "timestamp.io"
set :deploy_to, "/home/#{user}/sites/#{application}"
set :repository, "file://#{File.expand_path('.')}"
#set :repository, "ssh://user@example.com/~/git/test.git"

server "#{domain}", :app, :web, :db, :primary => true
set :deploy_via, :copy
set :copy_exclude, [".git", ".DS_Store"]
set :scm, :git
set :branch, "master"
set :use_sudo, false
set :keep_releases, 2
set :git_shallow_clone, 1
ssh_options[:paranoid] = false

namespace :deploy do
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

  task :after_setup do
    vhost_config =<<-EOF
<VirtualHost *:80>
  # Admin email, Server Name (domain name), and any aliases
  ServerAdmin admin@#{application}
  ServerName  www.#{application}
  ServerAlias #{application}

  # Index file and Document Root (where the public files are located)
  DirectoryIndex index.html index.php
  DocumentRoot /home/#{user}/sites/#{application}/current

  # Log file locations
  LogLevel warn
  ErrorLog  /home/#{user}/sites/#{application}/logs/error.log
  CustomLog /home/#{user}/sites/#{application}/logs/access.log combined
</VirtualHost>
    EOF
    put vhost_config, "/tmp/vhost_config"
    sudo "mv /tmp/vhost_config /etc/apache2/sites-available/#{application}"
    sudo "mkdir /home/#{user}/sites/#{application}/logs"
    sudo "a2ensite #{application}"
    run "sudo service apache2 restart"
  end
  
end

namespace :apache do
	[:stop, :start, :restart, :reload].each do |action|
		desc "#{action.to_s.capitalize} Apache"
		task action, :roles => :web do
			run "sudo service apache2 #{action.to_s}"
		end
	end
end