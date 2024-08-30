# rudl-dns-bind
Authorative DNS Server


## Problems with host system

Deploy only using direct IP allocation on host main IP (important to see the source ip):

```yaml
version: "3.7"

services:
  dns:
    image: rudl/dns-bind:unstable
    ports:
      - target: 53
        published: 53
        protocol: tcp
        mode: host
      - target: 53
        published: 53
        protocol: udp
        mode: host

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


## Configure the host system

To prevent `systemd-resolved` to block port 53 do the following changes:

```
systemctl stop systemd-resolved
```

edit `/etc/systemd/resolved.conf` to

```
[Resolve]
DNS=8.8.8.8
#FallbackDNS=
#Domains=~
#LLMNR=no
#MulticastDNS=no
#DNSSEC=no
#DNSOverTLS=no
#Cache=yes
DNSStubListener=no
#ReadEtcHosts=yes
```

and link default resolv.conf to /etc/resolv.conf:

```
ln -sf /run/systemd/resolve/resolv.conf /etc/resolv.conf
```


