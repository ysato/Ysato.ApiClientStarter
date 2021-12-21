This library is heavily inspired by [KnpLabs/php-github-api](https://github.com/KnpLabs/php-github-api)

# API Client Starter-Kit

A starter kit for a PHP restful API client application.

## Requirements

* PHP >= 7.4

## Quick install

Via [Composer](https://getcomposer.org).

This command will get you up and running quickly with a Guzzle HTTP client.

```bash
composer require ysato/api-client-starter:^1.0 guzzlehttp/guzzle:^7.0.1 http-interop/http-factory-guzzle:^1.0
```

## Advanced install

We are decoupled from any HTTP messaging client with help by [HTTPlug](https://httplug.io). 

### Using a different http client

```bash
composer require ysato/api-client-starter:^1.0 symfony/http-client nyholm/psr7
```

## License

`api-client-starter` is licensed under the MIT License - see the LICENSE file for details
