## The Rosetta Blog Platform

### Installation

#### DB Creds

    cat database.config | base64 -d > database.config.dec
    cat database.conf.dec | base64 -w 2000 > database.config

#### Password Protect Adminer

    echo -n 'username:' >> docker/web/htpasswd
    openssl passwd -apr1 >> docker/web/htpasswd

