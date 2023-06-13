# ryanwhowe/dot Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## 2.0.0 - 2023-06-13

### Added

* php native types for all method parameters have been set

### Changed

* Require php `^7.1 || ^8.0`

### Depreciated

* The methods verify that the delimiter is a non-zero-length string and if not throw an `\InvalidArgumentException`.
  Future versions will alter the exception thrown to a custom exception from the package which will be extended from a
  generic `\Exception`. To maintain compatibility if wrapping `Dot` calls in a try catch, catch an `\Exception` class
  instead of the `\InvalidArgumentException` class

## 1.1.0 - 2023-06-13

### Added

* `CHANGELOG.md` has been added with history to date
* New method `append()` for adding/creating array lists at a given key location
* New method `delete()` for unsetting data at a given key location
* New method `count()` for getting array counts at a given key location

## 1.0.1 - 2023-06-02

### Changed

* README.md documentation updated

## 1.0.0 - 2023-06-01

### Added

* Initial release of the library
* `set()` method
* `get()` method
* `has()` method
* 'flatten()' method