# rudl-dns-bind
Authorative DNS Server



## Problems with host system

Deploy only using direct IP allocation:

```yaml
version: "3.7"

services:
  dns:
    image: rudl/dns-bind:unstable
    ports:
      - "185.242.113.85:53:53/udp"
      - "185.242.113.85:53:53/tcp"

    environment:
      RUDL_GITDB_URL: http://gitdb
      RUDL_GITDB_CLIENT_ID: dns1
      RUDL_GITDB_CLIENT_SECRET: "{RSEC1.default.RUExSnpOR21xZGtk}"
      
      
```