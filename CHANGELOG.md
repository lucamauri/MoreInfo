# Changelog

All notable changes to the MoreInfo extension will be documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.0] - 2025-10-24

### Added
- Initial release of MoreInfo extension
- Implementation of `{{SERVERIP}}` magic word to display server's public IP address
- Support for multiple IP detection methods (SERVER_ADDR, LOCAL_ADDR, HTTP_X_FORWARDED_FOR, REMOTE_ADDR)
- IP address validation using PHP's filter_var
- Caching mechanism for IP address lookups
- Comprehensive documentation and installation instructions
- Support for both Composer and manual installation

### Features
- `{{SERVERIP}}` magic word for displaying server public IP
- Support for IPv4 and IPv6 addresses
- Fallback mechanisms for various server configurations
- Proper handling of proxy scenarios (X-Forwarded-For headers)

[1.0.0]: https://github.com/lucamauri/MoreInfo/releases/tag/1.0.0
