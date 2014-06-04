Mouf validators
===============

This package contains typical validators to be used in your application.
A validator is a class that decides whether a string is valid or not and implements the `ValidatorInterface`.

The `ValidatorInterface` is part of this package.

For instance, you could use an `EmailValidator` to validate that a string is a mail, etc...

List of embedded validators
---------------------------

- `RequiredValidator`: validates a value is not empty
- `NumericValidator`: validates a value is a number (optionnally an integer)
- `EmailValidator`: validates an email address
- `URLValidator`: validates a URL (starting with http://, https:// or ftp://)
- `MaxMinRangeValidator`: validates a value is between 2 bounds
- `MaxMinRangeLengthValidator`: validates a string length is between 2 bounds
- `SiretValidator`: validates a value is a valid SIRET number (French company id)

Javascript validation
---------------------

If the validator implements the `JsValidatorInterface`, it provides the code to be run both in PHP and in Javascript.
This means you can use this validator to generate Javascript code that validates any value.

I18n
----

The validators in the packet rely in [Fine](http://mouf-php.com/packages/mouf/utils.i18n.fine/README.md) for
translating validation error messages.
