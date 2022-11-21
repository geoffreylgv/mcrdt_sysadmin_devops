##########################################################
##	Get SSL Certificate On any domain W/ Let's Encrypt	##
##########################################################

# First install Cerbot (note that every distro have a special name for certbot)
 - For example for Debian we have to add 'python-certbot-apache'

```$ sudo apt install cerbot python-certbot-apache```

# After install add ssl let's ecrypt certificate on your domain (geoffreylgv.com)
```$ certbot --apache -d geoffreylgv.com```

add email address
and do some stuff
make sure redirect http to https

# do renew live certificate
```$ certbot renew --dry-run```
