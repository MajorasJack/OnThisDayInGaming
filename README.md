#OnThisDayInGaming

This is a lightweight Laravel application that scrapes Today in Video Game History data from [MobyGames](https://www.mobygames.com/stats/this-day) and emails it to whichever email you've specified in the `.env` file.

Installation:
* Clone repository
* `composer install`
* Copy `.env.example` to `.env`
* Update `.env` file with required credentials
* Run `php artisan moby-games:scrape` to test that it works
