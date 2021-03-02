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
      - "53:53/udp"
      - "53:53/tcp"
    networks:
      - dns_ext
    environment:
      RUDL_GITDB_URL: http://gitdb
      RUDL_GITDB_CLIENT_ID: dns1
      RUDL_GITDB_CLIENT_SECRET: "{RSEC1.default.RUExSnpOR21xZGtk}"
      
network:
  dns_ext:
    driver: bridge
    scope: swarm
    attachable: true
```

docker network create --attachable -d bridge --scope swarm  dns_ext
```
iptables -t nat -A PREROUTING -p udp -m udp -d 185.242.113.85 --dport 53 -j REDIRECT --to-ports 5353
iptables -t nat -A PREROUTING -p tcp -m tcp -d 185.242.113.85 --dport 53 -j REDIRECT --to-ports 5353
```