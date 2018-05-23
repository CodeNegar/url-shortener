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
## RESTful API Interface

URL Shortener provides an API interface with the following resources:

http method | url | description | status
------------|-----|----------|------------
POST | /api/urls | Create a new short URL | TODO
GET | /api/urls | Get list of latest short URLs | TODO
PUT | /api/urls/{url_id} | Update a specific short URL | TODO
DELETE | /api/urls/{url_id} | Delete a specific short URL | TODO
GET | /api/urls/{url_id} | Get details of a specific short URL | TODO
GET | /api/urls/{url_id}/stats | Get statistics  of a specific short URL | TODO