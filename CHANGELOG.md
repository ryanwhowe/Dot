# ryanwhowe/dot Changelog

All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/en/1.0.0/)
and this project adheres to [Semantic Versioning](http://semver.org/spec/v2.0.0.html).

## 3.1.0 - 2023-06-17

### Added

* `functions.php` has been added and included in the autoload to make wrapper function available globally (#19)
  * `dotGet()` has been added to wrap `Dot::Get()` static method (#19)
  * `dotSet()` has been added to wrap `Dot::Set()` static method (#19)
  * `dotHas()` has been added to wrap `Dot::Has()` static method (#19)
  * `dotCount()` has been added to wrap `Dot::Count()` static method (#19)
  * `dotDelete()` has been added to wrap `Dot::Delete()` static method (#19)
  * `dotAppend()` has been added to wrap `Dot::Append()` static method (#19)
  * `dotFlatten()` has been added to wrap `Dot::Flatten()` static method (#19)

## 3.0.0 - 2023-06-16

### Added

* `Dot::get()`, `Dot::count()`, `Dot::delete()`, `Dot::append()` can now optionally throw
  an `ryanwhowe\Dot\Exception\ArrayKeyNotSetException` if the requested searchKey is not set in the searchArray. (#17)

### Changed

* Require php `^8.0` (#17)
* All instances of thrown `InvalidArgumentExcpetion` have been refactored to
  be `ryanwhowe\Dot\Exception\InvalidDelimiterException` (#17)
* Updated Exceptions thrown. All Exceptions are extended from the `ryanwhowe\Dot\Exception\DotException` class which is
  extended from the base `\Expection` class. (#17)


## 2.1.0 - 2023-06-17

### Added

* `functions.php` has been added and included in the autoload to make wrapper function available globally (#20)
  * `dotGet()` has been added to wrap `Dot::Get()` static method (#20)
  * `dotSet()` has been added to wrap `Dot::Set()` static method (#20)
  * `dotHas()` has been added to wrap `Dot::Has()` static method (#20)
  * `dotCount()` has been added to wrap `Dot::Count()` static method (#20)
  * `dotDelete()` has been added to wrap `Dot::Delete()` static method (#20)
  * `dotAppend()` has been added to wrap `Dot::Append()` static method (#20)
  * `dotFlatten()` has been added to wrap `Dot::Flatten()` static method (#20)

## 2.0.0 - 2023-06-15

### Added

* php native types for all method parameters have been set (#4)
* php types for all method returns have been set, where possible (#4)

### Changed

* Require php `^7.1` (#4)

## 1.2.0 - 2023-06-17

### Added

* `functions.php` has been added and included in the autoload to make wrapper function available globally (#21)
    * `dotGet()` has been added to wrap `Dot::Get()` static method (#21)
    * `dotSet()` has been added to wrap `Dot::Set()` static method (#21)
    * `dotHas()` has been added to wrap `Dot::Has()` static method (#21)
    * `dotCount()` has been added to wrap `Dot::Count()` static method (#21)
    * `dotDelete()` has been added to wrap `Dot::Delete()` static method (#21)
    * `dotAppend()` has been added to wrap `Dot::Append()` static method (#21)
    * `dotFlatten()` has been added to wrap `Dot::Flatten()` static method (#21)


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