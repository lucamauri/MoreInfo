# MoreInfo Extension

The MoreInfo extension provides additional technical information about the MediaWiki server through custom magic words.

## Installation

### Using Composer (Recommended)

The recommended way to install MoreInfo is using Composer:

```bash
composer require lucamauri/moreinfo
```

Then add the following line to your `LocalSettings.php`:

```php
wfLoadExtension( 'MoreInfo' );
```

### Manual Installation

1. Download the extension files and place them in a directory called `MoreInfo` in your `extensions/` folder.
2. Add the following code at the bottom of your `LocalSettings.php`:

```php
wfLoadExtension( 'MoreInfo' );
```

3. Done! Navigate to Special:Version on your wiki to verify that the extension is successfully installed.

## Usage

### Magic Words

#### {{SERVERIP}}

Displays the public IP address of the server hosting the wiki.

**Example:**
```
The server IP is: {{SERVERIP}}
```

## Configuration

No configuration is required. The extension works out of the box.

## Security Considerations

**Note:** Displaying the server's IP address publicly may have security implications. Consider your use case carefully and restrict access if necessary.

## License

GNU General Public License, version 3 or later

## Author

Luca Mauri

## Links

* **GitHub Repository:** https://github.com/lucamauri/MoreInfo
* **Issues:** https://github.com/lucamauri/MoreInfo/issues
* **Changelog:** See [CHANGELOG.md](CHANGELOG.md)

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request or open an issue on GitHub.
