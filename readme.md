## URL shortener

Yet another URL shortener, this time using Laravel.

## Requirements

- PHP >= 7.1
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- MySQL, SQLite, SQL Server or Oracle

## Installation

Download and copy [MaxMind](https://geolite.maxmind.com/download/geoip/database/GeoLite2-City.mmdb.gz) GEO IP database and save to `storage/app/geoip.mmdb`

```bash
git clone https://github.com/CodeNegar/url-shortener.git
cd url-shortener && composer install
php artisan key:generate
php artisan migrate
php artisan serve
```