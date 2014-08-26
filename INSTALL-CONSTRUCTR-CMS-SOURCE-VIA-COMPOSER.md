###Install Constructr CMS via Composer (https://getcomposer.org)

1. Go to your destination DIR for ConstructrCMS on your server.
2. Create a new dir (constructrcms)
3. create a composer.json-File
	Content of composer.json-File:
		{
			"require": {
				"constructrcms/constructrcms": "dev-master"
			}
		}
4. Open the terminal of your webserver and change to your new constructr-cms DIR.
5. Run composer install-command
6. This will install the ConstructrCMS-Source at /vendor/constructrcms/constructrcms
7. Root your Domain to this destination or move this DIR to your webserver's ROOT
8. Now you should be able to open ConstructrCMS and proceed with setting up the DATABASE