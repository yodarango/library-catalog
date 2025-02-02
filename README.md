# STWC

## Features

### Library

- add new books with
  - title,
  - author(s),
  - ISBN number,
  - publisher,
  - year of publishing,
  - genre(s),
  - cover image,
  - description and
  - location;
- edit and delete existing books;
- manage books lent based on
  - who did you lend it to and
  - when did you lend it;
- browse your collection based on
  - authors,
  - publishers,
  - years of publishing,
  - genres and
  - lent status;
- manage your ebooks with ebook file upload;
- search your collection based on all fields (simple search) or only certain fields (smart search);
- protect your data from unwanted eyes with built-in authentication;
- Hungarian users are also able to import Hungarian books' data from the Moly website (Moly API Key required).

### Coffeeshop

- add new coffee
- edit coffee
- manage coffee
- delete coffee

### Prayer list

- add new prayer request
- edit prayer request
- manage prayer request
- archive prayer request

### Office bookings

- request hour slots for the ministers office

### Admin

- manage the library, coffee, office bookings, and prayer requests

### Public Website

- access manage the library, coffee, office bookings, and prayer
- visit the public site info

## Requirements

- PHP 8.0+
- MySql 8.0+

## DEV

1. Set the variables necessary in the `.env` and `config/config.php` file.
2. Rename the app accordingly
3. `docker-composer up -d`
4. Done

### backups

run `transfer_db_to_local.sh` to copy the docker data to local folder

### Deployment

run `./deploy.sh`

## Third-party code

- Catalog is build upon the excellent [Kirby Toolkit](https://github.com/getkirby/toolkit) written by Bastian Allgeier and available under the MIT License.
- Catalog uses [jQuery](https://github.com/jquery/jquery) created by the JS Foundation and available under the MIT License.
- Catalog uses [jQuery.fn.sortElements](https://github.com/padolsey-archive/jquery.fn/tree/master/sortElements) by James Padolsey, available under the Public Domain (unlicense).
- Catalog uses [Font Awesome](http://fontawesome.io/) icons cerated by Dave Gandy and available under the SIL Open Font License/MIT License.
- Catalog uses [php-fileupload-class](https://github.com/lodev09/php-fileupload-class) written by Jovanni Lo and available under the MIT License.

For licensing information of the above third-party components please see `THIRDPARTYREADME.md`.

## License

Catalog is released under the MIT License. Full text of the license can be found in the `LICENSE` file.
