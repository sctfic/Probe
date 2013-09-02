## Description

`Probe` est un logiciel de **visualisation de données météorologiques**.

L'application permet de collecter et de visualiser – de façon simple et élégante – les données issuent de station météo Davis Instrument ([Vantage Pro 2](http://www.davisnet.com/weather/products/vantage-pro-professional-weather-stations.asp)).

Le projet s'appuie sur des technologies libres et modernes pour fournir une **utilisation intuitive** :
 [Twitter Bootstrap](http://twitter.github.io/bootstrap/),
 [D3.js](http://mbostock.github.com/d3/),
 [CodeIgniter](http://codeigniter.com/),
 [jQuery](http://jquery.com/),
 [NginX](http://nginx.org/), etc.

L'application est basé sur des logiciels multi-plateforme. Rendant de ce fait `Probe` portable sur **Linux, Mac, Windows, etc.**

## Pré-requis

### Équipement

Il vous faut une [station Vantage pro2 Plus IP](http://www.davisnet.com/weather/products/vantage-pro-professional-weather-stations.asp).

### Serveur
* base de données : `MySQL` ≥5.5 ou `SQLite` ≥3 ;
* web : `Apache2`, `Lighttpd` ou `NginX` ;
* `PHP` ≥5.3.

### Localisation et traductions
Les traductions s'appuie sur le système `gettext`, il est donc impératifs d'installer les paquets de langues correspondants :

  * Ubuntu linux : `language-pack-*` (voir [Can't get gettext (php) on Ubuntu working](http://stackoverflow.com/questions/5257519/cant-get-gettext-php-on-ubuntu-working)).

## Installation

1. serveur de base de donnée :

    ```
    apt-get install mysql-client mysql-server # sqlite3
    ```

2. serveur web :

    ```
    apt-get install apache2 # lighttpd nginx
    ```

3. PHP

    ```
    apt-get install php5 # phpmyadmin
    ```

4. Localisation

    ```
    apt-get install gettext language-pack-en language-pack-fr # ...
    ```

5. Accéder à l'application avec l'URL de votre configuration, par exemple : [http://probe.dev/](http://probe.dev/)

## Feuille de route (roadmap)

Nous prévoyons de supporter l'installation sur les matériels suivants :

* routeur Netgear, avec le [firmware Tomato v1.28.9054 MIPSR2-beta K26 USB vpn3.6](http://tomatousb.org/doc:optware).

## Contact

* Twitter: [@ProbeMeteo](https://twitter.com/ProbeMeteo)

## Remarque
Nous ne sommes en aucune manière affilié à [Davis Instrument](http://www.davisnet.com/). Si vous avez besoin d'aide concernant leurs produits, veillez consulter le site web officiel : [http://www.davisnet.com/](http://www.davisnet.com/).
