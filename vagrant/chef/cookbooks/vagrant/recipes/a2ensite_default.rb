execute "enable-site default" do
  command "sudo a2ensite default"
end


service "apache2" do
  action :reload
 end