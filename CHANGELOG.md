# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/) (or at least it tries to).

## [Unreleased]
### Fixed
- Set auth driver to passport in config in InstallCommand
### Removed
- Unique index for user email in create users table migration in install command

## [0.40.0] - 2021-03-11
### Changed
- Min PHP version is now 8.0

## [0.39.2] - 2020-11-19
### Added
- Timeout to OAuth HTTP client singleton
### Fixed
- OAuth token route in auth controller

## [0.39.1] - 2020-11-19
### Fixed
- Laravel Passport invalid credentials error message

## [0.39.0] - 2020-11-19
### Changed
- mmCMS now requires `laravel/passport:^10.0` and `illuminate/*:^8.0`
- Upgraded to class-based factories

## [0.38.0] - 2020-11-19
### Changed
- mmCMS now requires `fruitcake/laravel-cors:^2.0`

## [0.37.0] - 2020-11-19
### Added
- Support to Laravel 8

## [0.36.4] - 2020-07-18
### Fixed
- `UniqueCaseInsensitive` validation rule issue with latest Laravel version

## [0.36.3] - 2020-06-28
### Changed
- Updated `thtg88/laravel-scaffold-commands` to `v0.2.2`

## [0.36.2] - 2020-06-14
### Added
- Minimum version of PHP to `7.4.6`
### Changed
- Laravel Scaffold Commands minimum version is now `0.2.1`
- PHPUnit minimum version is now `9.2`

## [0.36.1] - 2020-06-14
### Changed
- Updated `thtg88/laravel-scaffold-commands` to `v0.2.0`

## [0.36.0] - 2020-06-14
### Changed
- Scaffold commands are now under `scaffold:` namespace

## [0.35.1] - 2020-05-31
### Removed
- `tightenco/tlint` dev dependency as not used

## [0.35.0] - 2020-05-27
### Changed
- Load `role` relationship in `AuthController`
- Replace `$with` in `User` model with API resources
### Removed
- Eager-loaded fields on `ContentModel` model
- Eager-loaded fields on `User` model

## [0.34.0] - 2020-05-26
### Changed
- Replace `$with` in `ContentField` model with API resources
- Return API resource from base `Controller`

## [0.33.0] - 2020-05-25
### Added
- `thtg88/laravel-exists-without-soft-deleted` package for validation of model existence without soft-deleted ones

## [0.32.1] - 2020-05-24
### Changed
- Seeding improvements
- `ContentValidationRulesTableSeeder` improvements

## [0.32.0] - 2020-05-24
### Added
- Seed command

## [0.31.5] - 2020-05-24
### Fixed
- Eager load `content_field_content_validation_rules` relationship

## [0.31.4] - 2020-05-24
### Fixed
- Eager load `content_field_content_validation_rules` relationship

## [0.31.3] - 2020-05-24
### Fixed
- Eager load `content_field_content_validation_rules` relationship

## [0.31.2] - 2020-05-24
### Fixed
- Eager load `content_field_content_validation_rules` relationship

## [0.31.1] - 2020-05-24
### Fixed
- Eager load content_field_content_validation_rules relationship

## [0.31.0] - 2020-05-24
### Added
- Content Field Content Validation Rules scaffold
- Content Validation Rules seeder
### Removed
- `priority` and `content_migration_methohd_id` from content validation rules

## [0.30.1] - 2020-05-23
### Fixed
- Search request validation rule

## [0.30.0] - 2020-05-23
### Added
- Content Validation Rules search functionality
### Changed
- Search feature improvements

## [0.29.0] - 2020-05-21
### Added
- Content Validation Rules scaffold

## [0.28.2] - 2020-05-20
### Changed
- Improvements on `ExistsCaseInsensitive` validation rule

## [0.28.1] - 2020-05-17
### Changed
- Eager-load `content_type_content_validation_rules`

## [0.28.0] - 2020-05-17
### Added
- Content Type - Content Validation Rules scaffold

## [0.27.0] - 2020-05-10
### Added
- Show resource recovery

## [0.26.3] - 2020-05-02
### Changed
- Passport experiments

## [0.26.0] - 2020-05-02
### Changed
- Moved commands under `mmcms:` namespace

## [0.25.1] - 2020-05-02
### Fixed
- Is Mandatory field in content field migration

## [0.25.0] - 2020-05-02
### Changed
- Content Field general improvements
### Removed
- Content Field update routes

## [0.24.0] - 2020-04-21
### Changed
- Content Model general improvements
- Refactoring service provider using multiple traits

## [0.23.1] - 2020-04-19
### Added
- SEO entry allowed tables in request validation

## [0.23.0] - 2020-04-19
### Fixed
- Content Type validation

## [0.22.0] - 2020-04-19
### Added
- SEO policy support
- Repository namespace config variable

## [0.21.1] - 2020-04-18
### Fixed
- Recovery pagination filter

## [0.21.0] - 2020-04-18
### Added
- Image Category show support

## [0.20.0] - 2020-04-13
### Changed
- Image Category general improvements

## [0.19.0] - 2020-04-13
### Added
- Recovery resource support

## [0.18.1] - 2020-04-11
### Fixed
- User tests

## [0.18.0] - 2020-04-11
### Added
- `role_id` validation rules for store and update user
### Changed
- Downgrade minimum role for UserPolicy to `administrator`

## [0.17.0] - 2020-04-05
### Added
- Exists case insensitive validation rule
- Unique case insensitive validation rule
### Changed
- Email is now case insensitive on login
- Email is now case insensitive on registration

## [0.16.1] - 2020-03-29
### Added
- `post-install-cmd` and `post-update-cmd` composer scripts
### Changed
- Make sure tests are stan-ed

## [0.16.0] - 2020-03-29
### Added
- First feature test
- Orchestra TestBench dev dependency for running tests

## [0.15.0] - 2020-03-27
### Added
- PHPStan support
### Changed
- Several changes resulting from PHPStan

## [0.14.0] - 2020-03-27
### Removed
- Laravel 6 support

## [0.13.0] - 2020-03-27
### Changed
- Controllers now use Service pattern

## [0.12.0] - 2020-03-26
### Changed
- Several changes around HTTP Controller layer

## [0.11.1] - 2020-03-26
### Added
- Base Service layer

## [0.11.0] - 2020-03-26
### Changed
- Several changes around HTTP FormRequest layer

## [0.10.0] - 2020-03-26
### Added
- Database handling commands

## [0.9.0] - 2020-03-26
### Added
- Scaffold commands

## [0.8.1] - 2020-03-26
### Changed
- Refactored `InstallCommand`

## [0.8.0] - 2020-03-26
### Changed
- Improved HTTP exceptions support
- Make InstallCommand extend mmCMS handler instead of re-writing it

## [0.7.0] - 2020-03-26
### Added
- Base exception handler

## [0.6.0] - 2020-03-26
### Added
- Support for Laravel 7

## [0.5.0] - 2020-03-08
### Added
- `check-style` composer script
- `fix-style` composer script
- `test` composer script
- PHP CS Fixer support
### Changed
- Tests namespace
- Upgraded Laravel Passport to v8
- Upgraded Laravel CORS to Fruitcake v1
### Removed
- Tlint dev dependency
- `stan` composer script

## [0.4.2] - 2019-01-20
### Changed
- Assign user role to newly created user if N/A

## [0.4.1] - 2019-01-19
### Added
- Sort name and direction support for pagination

## [0.4.0] - 2018-11-25
### Added
- Refresh token endpoint

## [0.3.3] - 2018-11-22
### Fixed
- Journal mode not working

## [0.3.2] - 2018-10-13
### Changed
- Recaptcha on registration is now configurable
### Fixed
- User role not set properly on registration

## [0.3.1] - 2018-10-13
### Changed
- Now checks for app key from config helper instead of env helper for consistency

## [0.3.0] - 2018-09-30
### Added
- Google ReCaptcha for user registration
- Publish ReCaptcha config in install command

## [0.2.2] - 2018-09-30
### Fixed
- .htaccess creation in install command not checking right file name

## [0.2.1] - 2018-09-27
### Added
- .htaccess in install command if N/A in app root folder
- APP_KEY in install command if not available via key:generate method
### Fixed
- migrate in install command now forces, so it works on production applications

## [0.2.0] - 2018-09-23
### Added
- Paginate method
- Role endpoints and handling
### Changed
- Installation command improvements
### Removed
- Auth route group

## [0.1.0] - 2018-07-13
### Added
- First release of mmCMS. Basic Installation command and setup with users and roles.
