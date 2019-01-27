# Change Log
All notable changes to this project will be documented in this file.

The format is based on [Keep a Changelog](http://keepachangelog.com/)
and this project adheres to [Semantic Versioning](http://semver.org/) (or at least it tries to).

## [Unreleased]
### Fixed
- Set auth driver to passport in config in InstallCommand
- Set event listeners in EventServiceProvider in InstallCommand
- Replace content replace with stubs for event listeners
### Removed
- Unique index for user email in create users table migration in install command

## [0.4.0] - 2018-11-25
## Added
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
