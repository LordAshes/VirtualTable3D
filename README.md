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

Note: The value of player is also used to determine the player specific character sheet
and corresponding roll options. To be able to use this benefit, ensure that the name
provided matches the (case sensitive) file name of a character sheet in the
/resources/sheets folder.

# Change Log

2021.04.21:
- Added support for rolling with advantage, normal and disadvantage.
- Added radio input selection for advantage (Adv), normal (Nor), or disadvantage (Dis).
- Based on the radio input selection the roll's Nor() is change to Adv(), Nor() or Dis().
