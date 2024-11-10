### Project structure

```
|-- Dockerfile
|-- LICENSE
|-- README.md
|-- THIRDPARTYREADME.md
|-- add.php
|-- app/
|   |-- add.php
|   |-- authors.php
|   |-- delete.php
|   |-- display-author.php
|   |-- display-ebooks.php
|   |-- display-genre.php
|   |-- display-lent.php
|   |-- display-publisher.php
|   |-- display-year.php
|   |-- display.php
|   |-- edit.php
|   |-- find.php
|   |-- genres.php
|   |-- help.php
|   |-- import.php
|   |-- index.php
|   |-- lib/
|   |   |-- class.file.php
|   |   |-- class.upload.php
|   |-- login.php
|   |-- logout.php
|   |-- page.php
|   |-- publishers.php
|   |-- random.php
|   |-- search.php
|   |-- snippets/
|   |   |-- collection.php
|   |   |-- footer-setup.php
|   |   |-- footer.php
|   |   |-- header-setup.php
|   |   |-- header.php
|   |   |-- logged-in.php
|   |   |-- results.php
|   |   |-- table-head.php
|   |   |-- update-status.php
|-- assets/
|   |-- css/
|   |   |-- font-awesome.min.css
|   |   |-- index.css
|   |-- fonts/
|   |   |-- FontAwesome.otf
|   |   |-- fontawesome-webfont.eot
|   |   |-- fontawesome-webfont.svg
|   |   |-- fontawesome-webfont.ttf
|   |   |-- fontawesome-webfont.woff
|   |   |-- fontawesome-webfont.woff2
|   |-- icons/
|   |   |-- apple-touch-icon-152x152.png
|   |   |-- apple-touch-icon-167x167.png
|   |   |-- apple-touch-icon-180x180.png
|   |   |-- apple-touch-icon.png
|   |   |-- favicon.png
|   |   |-- icon-hires.png
|   |   |-- icon-normal.png
|   |-- js/
|   |   |-- jquery.min.js
|   |   |-- jquery.sortElements.js
|   |   |-- showhide.js
|   |   |-- tablesort.js
|-- authors.php
|-- config/
|   |-- config.php
|   |-- configure.php
|   |-- connect.php
|   |-- setup.php
|-- delete.php
|-- display.php
|-- docker-compose.yml
|-- ebooks/
|   |-- index.php
|-- edit.php
|-- find.php
|-- genres.php
|-- help.php
|-- import.php
|-- index.php
|-- languages/
|   |-- en-US.php
|   |-- hu-HU.php
|-- login.php
|-- logout.php
|-- page.php
|-- project_structure.md
|-- publishers.php
|-- random.php
|-- search.php
|-- toolkit/
|   |-- bootstrap.php
|   |-- composer.json
|   |-- helpers.php
|   |-- lib/
|   |   |-- a.php
|   |   |-- bitmask.php
|   |   |-- brick.php
|   |   |-- c.php
|   |   |-- cache/
|   |   |   |-- driver/
|   |   |   |   |-- apc.php
|   |   |   |   |-- file.php
|   |   |   |   |-- memcached.php
|   |   |   |   |-- mock.php
|   |   |   |   |-- session.php
|   |   |   |-- driver.php
|   |   |   |-- value.php
|   |   |-- cache.php
|   |   |-- collection.php
|   |   |-- cookie.php
|   |   |-- crypt.php
|   |   |-- data.php
|   |   |-- database/
|   |   |   |-- query.php
|   |   |-- database.php
|   |   |-- db.php
|   |   |-- detect.php
|   |   |-- dimensions.php
|   |   |-- dir.php
|   |   |-- email.php
|   |   |-- embed.php
|   |   |-- error.php
|   |   |-- errorreporting.php
|   |   |-- escape.php
|   |   |-- exif/
|   |   |   |-- camera.php
|   |   |   |-- location.php
|   |   |-- exif.php
|   |   |-- f.php
|   |   |-- folder.php
|   |   |-- header.php
|   |   |-- html.php
|   |   |-- i.php
|   |   |-- l.php
|   |   |-- media.php
|   |   |-- obj.php
|   |   |-- pagination.php
|   |   |-- password.php
|   |   |-- r.php
|   |   |-- redirect.php
|   |   |-- remote.php
|   |   |-- response.php
|   |   |-- router.php
|   |   |-- s.php
|   |   |-- server.php
|   |   |-- silo.php
|   |   |-- sql.php
|   |   |-- str.php
|   |   |-- system.php
|   |   |-- thumb.php
|   |   |-- timer.php
|   |   |-- toolkit.php
|   |   |-- tpl.php
|   |   |-- upload.php
|   |   |-- url.php
|   |   |-- v.php
|   |   |-- visitor.php
|   |   |-- xml.php
|   |   |-- yaml.php
|   |-- phpunit.xml
|   |-- readme.md
|   |-- test/
|   |   |-- ATest.php
|   |   |-- BitmaskTest.php
|   |   |-- CTest.php
|   |   |-- CollectionTest.php
|   |   |-- DbTest.php
|   |   |-- DimensionsTest.php
|   |   |-- DirTest.php
|   |   |-- EmbedTest.php
|   |   |-- ErrorReportingTest.php
|   |   |-- FTest.php
|   |   |-- HTMLTest.php
|   |   |-- HeaderTest.php
|   |   |-- HelpersTest.php
|   |   |-- LTest.php
|   |   |-- MediaTest.php
|   |   |-- ObjTest.php
|   |   |-- PaginationTest.php
|   |   |-- PasswordTest.php
|   |   |-- RTest.php
|   |   |-- ServerTest.php
|   |   |-- StrTest.php
|   |   |-- SystemTest.php
|   |   |-- TimerTest.php
|   |   |-- UrlTest.php
|   |   |-- VTest.php
|   |   |-- VisitorTest.php
|   |   |-- XmlTest.php
|   |   |-- etc/
|   |   |   |-- content.php
|   |   |   |-- images/
|   |   |   |   |-- favicon.png
|   |   |   |-- system/
|   |   |   |   |-- executable.sh
|   |   |   |   |-- nonexecutable.sh
|   |   |-- lib/
|   |   |   |-- bootstrap.php
|   |-- vendors/
|   |   |-- abeautifulsite/
|   |   |   |-- SimpleImage.php
|   |   |-- mimereader/
|   |   |   |-- mimereader.php
|   |   |-- yaml/
|   |   |   |-- yaml.php
```
