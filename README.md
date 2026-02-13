## Inspiered by the extention [cloudflare_ip](https://www.phpbb.com/customise/db/extension/cloudflare_ip) this plug in is aim to get the user real IP if the PHPBB is behind a reverse proxy. 

## How to install/update X-Real-Ip

 0.0 If you have an active previous version X-Real-Ip, go to the Admin Control Panel -> Customise -> Manage extensions
 0.1 Disable the extension X-Real-Ip (do not click "delete data" to keep all your configured questions and answers)
 0.2 Delete folder `ext/brctx/xrealip`
 1. Upload the first/new version into `ext/brctx/xrealip`
 2. go to the Admin Control Panel -> Customise -> Manage extensions
 3. Enable the extension (this will run the necessary migrations and event updates)
    
If you replaced the files before disabling the extension, you'll probably get an error (blank page). Restore the files of the previous version and follow the recommended update guide above.
