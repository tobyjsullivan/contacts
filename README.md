Contacts
===
An address book for busy tweeps. Built on the Yii framework.

Quick Eval
---
If all goes well, you should be able to get a copy up and running with just a few commands.

	git clone https://github.com/tobyjsullivan/contacts.git --recursive
	cd contacts
	./set-config-default.sh
	./unittest # Yeah, the vagrant up step takes forever
	curl 192.168.33.11
	
Hopefully that goes smoothly.

Installation
---
When cloning the repo, be sure to use --recursive if you intend to use vagrant. This should get you the chef 
recipes that are submodules.

    git clone https://github.com/tobyjsullivan/contacts.git --recursive
   
Following that, just setup the default configuration with this command.

	./set-config-default.sh

Vagrant
---
The easiest way to get a development environment up and running is to use the vagrant provided. Ensure you have 
vagrant installed then you should be able to just:

	cd vagrant
	vagrant up
	
All pre-req's should be installed and the server will be up and running at ip 192.168.33.11. If the chef fails, 
ensure you've retrieved the submodules as well as stated in INSTALLATION.

Testing
---
The unit tests are easiest run with the vagrant box. Simply ensure you have vagrant installed and fire off the unittest script.

	./unittest
	
This script will kick up the vagrant box and then execute the unit tests.

Additionally, the unittest script supports passing arguments into phpunit. Of particular helpfulness is the verbose flag:

	./unittest -v
