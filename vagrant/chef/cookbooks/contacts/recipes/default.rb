#
# Cookbook Name:: contacts
# Recipe:: default
#
# This recipe is specifically for use in setting up the Contacts app test environment. It's primary
# purpose is to initialise the databases.
#

include_recipe "mysql::client"
include_recipe "mysql::server"

execute "create_databases" do
	command "mysql -u root --password=#{node['mysql']['server_root_password']} < /var/sql/dbs_1.00.sql"
end

execute "populate_database" do
	command "mysql -u root --password=#{node['mysql']['server_root_password']} contacts < /var/sql/schema_1.00.sql"
end

execute "populate_test_database" do
	command "mysql -u root --password=#{node['mysql']['server_root_password']} contacts_test < /var/sql/schema_1.00.sql"
end
