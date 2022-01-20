
# Video Chat using Laravel & Vue

Peer to peer video calling using simple-peer WebRTC library & self hosted turn server.

## Requirements

A basic Nginx, MySQL & PHP server setup

A pusher account with client events enabled
(https://pusher.com/)
    
One domain with 2 subdomain (All pointing to server's public IP)
        
        example.com
        turn.example.com
        stun.example.com
    
SSL Certificate for all 3 domains (Preferably a Wildcard SSL or You may also use Let's encrypt free SSL)

Coturn server (https://github.com/coturn/coturn)
## Coturn Setup

### Installation
    sudo apt-get -y update
    sudo apt-get upgrade
    sudo reboot
    sudo apt-get install coturn
    sudo systemctl stop coturn

### Enable TURN server
    sudo nano /etc/default/coturn
Remove the # before TURNSERVER_ENABLED & save

### TURN server configuration
    sudo nano /etc/turnserver.conf

#### turnserver.conf

    # TURN server name and realm
    realm=turn.example.com
    server-name​=​turn.example.com​
    
    # Use fingerprint in TURN message
    fingerprint

    # IPs the TURN server listens to
    listening-ip=0.0.0.0

    # External IP-Address of the TURN server (Public IP of Server)
    external-ip​=​45.77.55.34

    # Main listening port
    listening-port=3478

    # Further ports that are open for communication
    min-port=10000
    max-port=20000

    # Log file path
    log-file​=​/var/log/turnserver.log

    # Enable verbose logging
    verbose

    # Specify the user for the TURN authentification
    user=test:test123

    # Enable long-term credential mechanism
    lt-cred-mech

    # SSL certificates
    cert​=​/etc/letsencrypt/live/​turn.example.com-0001​/cert.pem
    pkey​=​/etc/letsencrypt/live/​turn.example.com-0001/privkey.pem

    # 443 for TURN over TLS, which can bypass firewalls
    tls-listening-port=443


Make sure you change the domain & SSL certificate location.
Remember to Enable port 80 and 443 on inbound security rules & Enable port 3478 and 5349 for TCP and UDP incoming connection.

    sudo systemctl start coturn
## Testing TURN & STUN server

We can test our STUN and TURN server from the tool on Trickle ICE.
https://webrtc.github.io/samples/src/content/peerconnection/trickle-ice/

If you test a STUN server, it works if you can gather a candidate with type "srflx". If you test a TURN server, it works if you can gather a candidate with type "relay".
## Installation

```bash
  composer install
  npm install
```

    
## Environment Variables

To run this project, you will need to add your own environment variables from .env.example to your .env file

