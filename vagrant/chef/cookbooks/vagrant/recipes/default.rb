# vagrant/recipes/default.rb
execute "update sources" do
  command "apt-get update -y"
end