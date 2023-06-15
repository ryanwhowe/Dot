# ryanwhowe/dot Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## Unreleased

* There will be a 3.x branch created for php 8.0, there is little differences between the functionality of the different
  version of the package. The primary difference is the supported versions which have to do with the development of the
  package and the dev dependencies.

## 2.0.0 - 2023-06-15

### Added

* php native types for all method parameters have been set (#4)
* php types for all method returns have been set, where possible (#4)

### Changed

* Require php `^7.1` (#4)

### Depreciated

* The methods verify that the delimiter is a non-zero-length string and if not throw an `\InvalidArgumentException`.
  Future versions will alter the exception thrown to a custom exception from the package which will be extended from a
  generic `\Exception`. To maintain compatibility if wrapping `Dot` calls in a try catch, catch an `\Exception` class
  instead of the `\InvalidArgumentException` class

## 1.1.0 - 2023-06-13

### Added

* `CHANGELOG.md` has been added with history to date (#12)
* New method `append()` for adding/creating array lists at a given key location (#11)
* New method `delete()` for unsetting data at a given key location (#11)
* New method `count()` for getting array counts at a given key location (#11)

## 1.0.1 - 2023-06-02

### Changed

* README.md documentation updated(#5)

## 1.0.0 - 2023-06-01

### Added

* Initial release of the library (#1)
* `set()` method (#1)
* `get()` method (#1)
* `has()` method (#1)
* `flatten()` method (#1)