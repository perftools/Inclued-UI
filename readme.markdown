# Inclued UI

This is a single file script designed to provide some UI for Inclued (http://php.net/manual/en/book.inclued.php)

Sample Image: https://github.com/preinheimer/Inclued-UI/raw/master/inclued-wondernetwork.png

## Usage Instructions

1.  Install inclued extension
2.  Turn it on, configure it to run automagically with php.ini
3.  Tell PHP to save the files somewhere, preferably somewhere inteligent. I would suggest against putting them on a tape drive, sys-admins get really scary when they're angry
4.  Drop the inclued.php file inside your document root. Actually, place it there gently, things can break when dropped
5.  Edit the file, gently, to set the paths correctly.
6.  Fairys get wings when you clap your hands, or when you include trailing slashes as instructed
7.  Visit a few pages on your site
8.  Visit inclued.php
9.  Go fix that thing you missed
10.  Start enjoying your call graphs.

Please don't install this in production *see note about angry sys-admins*

## Debugging Tips

* Ensure you've got graphviz installed, and you know where dot is
* The program prints out the commands it's trying to execute when things go poorly, run them yourself, see what happens
* If the graph is small edit the value (default 6.6) inside the phpdeps section of gengraph.php


