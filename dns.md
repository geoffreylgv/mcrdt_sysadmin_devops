
<!DOCTYPE HTML>
<html>
 <head>
  <meta charset="utf-8"/>
  <title>
  Configurer un serveur DNS Bind - Ubuntu 
  </title>
  <link href="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.1/styles/github.min.css" rel="stylesheet"/>
  <style type="text/css">
   body,table tr{background-color:#fff}table tr td,table tr th{border:1px solid #ccc;text-align:left;padding:6px 13px;margin:0}pre code,table,table tr{padding:0}hr,pre code{background:0 0}body{font:16px Helvetica,Arial,sans-serif;line-height:1.4;color:#333;word-wrap:break-word;padding:10px 15px}strong,table tr th{font-weight:700}h1{font-size:2em;margin:.67em 0;text-align:center}h2{font-size:1.75em}h3{font-size:1.5em}h4{font-size:1.25em}h1,h2,h3,h4,h5,h6{font-weight:700;position:relative;margin-top:15px;margin-bottom:15px;line-height:1.1}h1,h2{border-bottom:1px solid #eee}hr{height:0;margin:15px 0;overflow:hidden;border:0;border-bottom:1px solid #ddd}a{color:#4183C4}a.absent{color:#c00}ol,ul{padding-left:15px;margin-left:5px}ol{list-style-type:lower-roman}table tr{border-top:1px solid #ccc;margin:0}table tr:nth-child(2n){background-color:#aaa}table tr td :first-child,table tr th :first-child{margin-top:0}table tr td:last-child,table tr th :last-child{margin-bottom:0}img{max-width:100%}blockquote{padding:0 15px;border-left:4px solid #ccc}code,tt{margin:0 2px;padding:0 5px;white-space:nowrap;border:1px solid #eaeaea;background-color:#f8f8f8;border-radius:3px}pre code{margin:0;white-space:pre;border:none}.highlight pre,pre{background-color:#f8f8f8;border:1px solid #ccc;font-size:13px;line-height:19px;overflow:auto;padding:6px 10px;border-radius:3px}
  </style>
 </head>
 <body>
  <h2 id="installer-bind9-sous-ubuntu-server-1604">
   Installer bind9  sous Ubuntu Server 16.04
  </h2>
  <p>
   <code>
    apt-get install bind9 bind9utils bind9-doc
   </code>
  </p>
  <p>
   <strong>
    Éditer le fichier « options »  </strong>(attention : acl internal ip publique si message 'GOT Recursion not available')
  
   <br/>
   <code>
    vi /etc/bind/named.conf.options
   </code>
  </p>
  <blockquote>
   <p>
    <em>
     //Autoriser les IP locales à accéder au service DNS
    </em>
    <br/>
    acl internal { 127.0.0.0/24; ip publique; 192.168.100.0/24; };
    <br/>
    options {
    <br/>
    directory “/var/cache/bind”;
   </p>
   <p>
    //recursion yes;
    <br/>
    allow-recursion { internal; };
    <br/>
    allow-query { internal; };
   </p>
   <p>
    <em>
     //Si le serveur doit interroger un DNS externe, renseigner la ou les IP ici :
    </em>
    <br/>
    forwarders {
    <br/>
    80.67.169.12;
    <br/>
    80.67.169.40;
    <br/>
    };
   </p>
   <p>
    auth-nxdomain no;    # conform to RFC1035
   </p>
   <p>
    };
   </p>
  </blockquote>
  <p>
   <strong>
    Relancer le service
   </strong>
   <br/>
   <code>
    systemctl restart bind9
   </code>
  </p>
  <p>
   <strong>
    Éditer le fichier principal de configuration :
   </strong>
   <br/>
   <code>
    vi /etc/bind/named.conf
   </code>
  </p>
  <blockquote>
   <p>
    include “/etc/bind/named.conf.options”;
    <br/>
    include “/etc/bind/named.conf.local”;
    <br/>
    include “/etc/bind/named.conf.default-zones”;
   </p>
  </blockquote>
  <p>
   <strong>
    Éditer le fichier local de configuration :
   </strong>
   <br/>
   <code>
    vi /etc/bind/named.conf.local
   </code>
  </p>
  <blockquote>
   <p>
    zone “zone.domaine.fr” {
    <br/>
    type master;
    <br/>
    file “/etc/bind/host.zone.domaine.fr”;
    <br/>
    allow-query { any; };
   </p>
   <p>
    };
    <br/>
    zone “100.168.192.in-addr.arpa” {
    <br/>
    type master;
    <br/>
    file “/etc/bind/rev.zone.domaine.fr”;
    <br/>
    allow-query { any; };
    <br/>
    };
   </p>
  </blockquote>
  <p>
   <strong>
    Éditer les fichiers de zones (host et rev) :
   </strong>
   <br/>
   <span style="color:red">
    <strong>
     Attention au “Serial”
    </strong>
   </span>
   <br/>
   <strong>
    - Fichier hosts
   </strong>
   <br/>
   <code>
    vi /etc/bind/host.zone.domaine.fr
   </code>
  </p>
  <blockquote>
   <p>
    $TTL 86400
    <br/>
    @   IN  SOA     node1.zone.domaine.fr.    root.node1.zone.domaine.fr. (
    <br/>
    2016120308  ;Serial
    <br/>
    3600        ;Refresh
    <br/>
    1800        ;Retry
    <br/>
    604800      ;Expire
    <br/>
    86400       ;Minimum TTL
    <br/>
    )
    <br/>
    @       IN  NS     node1.zone.domaine.fr.
   </p>
   <p>
    ; On commence ici
   </p>
   <p>
    node1  IN  A           192.168.100.1
    <br/>
    node2  IN  A           192.168.100.2
    <br/>
    node3  IN  A           192.168.100.3
   </p>
   <p>
    ; C’est fini !
   </p>
  </blockquote>
  <p>
   <strong>
    - Fichier rev
   </strong>
   <br/>
   <code>
    vi /etc/bind/rev.zone.domaine.fr
   </code>
  </p>
  <blockquote>
   <p>
    $TTL 86400
    <br/>
    @   IN  SOA     node1.zone.domaine.fr. root.node1.zone.domaine.fr. (
   </p>
   <p>
    2016120308  ;Serial
    <br/>
    3600        ;Refresh
    <br/>
    1800        ;Retry
    <br/>
    604800      ;Expire
    <br/>
    86400       ;Minimum TTL
    <br/>
    )
    <br/>
    @       IN  NS          node1.zone.domaine.fr.
    <br/>
    node1  IN  A           192.168.100.1
    <br/>
    ; On commence ici
   </p>
   <p>
    1     IN  PTR  node1.zone.domaine.fr.
    <br/>
    2     IN  PTR  node2.zone.domaine.fr.
    <br/>
    3     IN  PTR  node3.zone.domaine.fr.
   </p>
   <p>
    ; C’est fini !
   </p>
  </blockquote>
  <p>
   <strong>
    Donner les droits au dossier de configuration de Bind9
   </strong>
   :
   <br/>
   <code>
    chmod -R 755 /etc/bind
   </code>
   <br/>
   <code>
    chown -R bind:bind /etc/bind
   </code>
  </p>
  <p>
   <strong>
    Vérifier la configuration :
   </strong>
   <br/>
   <code>
    named-checkconf /etc/bind/named.conf
   </code>
   <br/>
   <code>
    named-checkconf /etc/bind/named.conf.local
   </code>
   <br/>
   <code>
    named-checkzone zone.domaine.fr /etc/bind/host.zone.domaine.fr
   </code>
   <br/>
   Doit renvoyer
  </p>
  <blockquote>
   <p>
    zone zone.domaine.fr/IN: loaded serial 2016120308
    <br/>
    OK
   </p>
  </blockquote>
  <p>
   <code>
    named-checkzone zone.domaine.fr /etc/bind/rev.zone.domaine.fr
   </code>
   <br/>
   Doit renvoyer
  </p>
  <blockquote>
   <p>
    zone zone.domaine.fr/IN: loaded serial 2016120308
    <br/>
    OK
   </p>
  </blockquote>
  <p>
   <strong>
    Configurer les interfaces réseau
   </strong>
   <br/>
   <code>
    vi /etc/network/interfaces
   </code>
  </p>
  <blockquote>
   <p>
    # The secondary network interface
    <br/>
    auto enp8s0f1
    <br/>
    iface enp8s0f1 inet static
    <br/>
    address 192.168.100.1
    <br/>
    netmask 255.255.255.0
    <br/>
    network 192.168.100.0
    <br/>
    broadcast 192.168.100.255
    <br/>
    gateway 192.168.100.1
    <br/>
    # dns-* options are implemented by the resolvconf package, if installed
    <br/>
    dns-search zone.domaine.fr
    <br/>
    dns-nameservers 192.168.100.1
   </p>
   <p>
    #The primary network interface
    <br/>
    <em>
     #Ici notre attribution IP de l’interface réseau « externe » se fait via le serveur DHCP du service.
    </em>
    <br/>
    auto enp8s0f0
    <br/>
    iface enp8s0f0 inet dhcp
   </p>
  </blockquote>
  <p>
   <strong>
    Relancer le service :
   </strong>
   <br/>
   <code>
    systemctl restart bind9
   </code>
  </p>
  <p>
   <strong>
    Vérifier le fichier /etc/resolv.conf
   </strong>
  </p>
  <blockquote>
   <p>
    search zone.domaine.fr  domaine.fr
    <br/>
    nameserver 192.168.100.1
    <br/>
   </p>
  </blockquote>
  <p>
   Verifier que le serveur DNS fonctionne :
  </p>
  <pre><code>    nslookup node2  
    nslookup node3  
    nslookup 192.168.100.3  
    nslookup 192.168.100.2
</code></pre>
  <script src="http://cdnjs.cloudflare.com/ajax/libs/highlight.js/8.1/highlight.min.js">
  </script>
  <script>
   hljs.initHighlightingOnLoad();
  </script>
  <script src="https://cdn.mathjax.org/mathjax/latest/MathJax.js?config=TeX-AMS-MML_HTMLorMML" type="text/javascript">
  </script>
  <script type="text/javascript">
   MathJax.Hub.Config({"showProcessingMessages" : false,"messageStyle" : "none","tex2jax": { inlineMath: [ [ "$", "$" ] ] }});
  </script>
 </body>
</html>

