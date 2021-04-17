# VirtualTable3D
Web base 3D version of Virtual Table
(Demo video available at https://youtu.be/fZBrRo1l784)

# Installation Instructions:
1. Ensure PHP is installed
2. Install Laravel (either a new copy or from the Base_Laravel_Installation ZIP file)
3. Install the GitHub contents (app, config, database, resources and routes folders)

# Starting The Server
PHP artisan serve

# Launching The VirtualTable3D Session for GM
http://127.0.0.1:8000/?player=GM&module=Test3

Where "127.0.0.1" can be replaced with the WAN IP for the server.
Where "Test3" is the module that is loaded (Test3.txt in resources/modules)

# Launching The VirtualTable3D Session for Players
http://127.0.0.1:8000/?player=name&module=Test3

Where "127.0.0.1" can be replaced with the WAN IP for the server.
Where name is replaced with a unique identification of the player (anything but "GM").
Where "Test3" is the module that is loaded (Test3.txt in resources/modules)
