[![Build Status](https://travis-ci.com/CodeNegar/url-shortener.svg?branch=master)](https://travis-ci.com/CodeNegar/url-shortener)
## URL shortener

Yet another URL shortener, this time API driven using Laravel + Bootstrap + Vue.js

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
cp .env.example .env
php artisan key:generate
php artisan jwt:secret
```
Set envioment variables (e.g. database connection,...)
```
php artisan migrate
php artisan serve
```
## Deployment to AWS
This project comes with a basic Dockerfile which makes it easy to deploy.
Zip everything and upload it to AWS Elastic Beanstalk with Docker as the platform. The process can be automated in CI/CD pipeline.

## Setting up characters for short URL IDs
By default short URLs IDs will be chosen from the following list:

> 0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ

You can use your customized list of characters (only numeric, only lowercase, only alphabet, only 0 and 1 like binary,...) by assigning it to an Environment variable called:

> URL_SHORTENER_CHARS

You may scramble the characters to make it hard to guess next, previous and count of shortened links. For example:

> URL_SHORTENER_CHARS=wkfHGhz8Cr4MW2SE50QOiKl3Aa6LDIXjF7Bc1dqxyT9

Any combination is acceptable, just make sure there is no duplicate character in your list and don't modify once short URLs are created.

You may force the ID counter to start from a particular number (default is 1) by setting another environment variable called:

> URL_SHORTENER_ID_MIN=1000

You may force the ID counter step to any particular amount (default is 1) by setting another environment variable called:

> URL_SHORTENER_ID_STEP=5


## RESTful API Interface

URL Shortener provides an API interface with the following resources:

http method | url | description | status
------------|-----|----------|------------
POST | /api/urls | Create a new short URL | Done
GET | /api/urls | Get list of latest short URLs | Done
GET | /api/urls/{url_id}/stats | Get statistics  of a specific short URL | Done
GET | /api/urls/{url_id} | Get details of a specific short URL | Done
PUT | /api/urls/{url_id} | Update a specific short URL | TODO
DELETE | /api/urls/{url_id} | Delete a specific short URL | TODO
