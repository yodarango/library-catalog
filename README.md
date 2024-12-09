# Catalog

![Meet Catalog](https://paszternak.me/catalog-app/catalog_screen8.jpg)

Catalog is a PHP + MySql application to manage your home library. If you don't care about who hosts your stuff, choose LibraryThing. If you want complex, almost library-like stuff, go for OpenBiblio, Koha or Evergreen. But if you want to own your book data and you would keep it simple without all the functionalities too much for an average user, Catalog is for you.

Read on, or see [the Catalog Wiki](https://github.com/psztrnk/catalog/wiki) for more information.

## Features

With Catalog, you can

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

## Requirements

- PHP 8.0+
- MySql 8.0+

## DEV

1. Set the variables necessary in the `.env` and `config/config.php` file.
2. Rename the app accordingly
3. `docker-composer up -d`
4. Done

## Third-party code

- Catalog is build upon the excellent [Kirby Toolkit](https://github.com/getkirby/toolkit) written by Bastian Allgeier and available under the MIT License.
- Catalog uses [jQuery](https://github.com/jquery/jquery) created by the JS Foundation and available under the MIT License.
- Catalog uses [jQuery.fn.sortElements](https://github.com/padolsey-archive/jquery.fn/tree/master/sortElements) by James Padolsey, available under the Public Domain (unlicense).
- Catalog uses [Font Awesome](http://fontawesome.io/) icons cerated by Dave Gandy and available under the SIL Open Font License/MIT License.
- Catalog uses [php-fileupload-class](https://github.com/lodev09/php-fileupload-class) written by Jovanni Lo and available under the MIT License.

For licensing information of the above third-party components please see `THIRDPARTYREADME.md`.

## License

Catalog is released under the MIT License. Full text of the license can be found in the `LICENSE` file.

# LEFT OFF

I added functionality to add and delete in the admin library, I need to make sure that images can be uploaded next. Then make sure that the scanner works calling google books.
