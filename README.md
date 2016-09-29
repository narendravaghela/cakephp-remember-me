# RememberMe plugin for CakePHP

[![Build Status](https://travis-ci.org/narendravaghela/cakephp-remember-me.svg?branch=master)](https://travis-ci.org/narendravaghela/cakephp-remember-me)
[![codecov.io](https://codecov.io/github/narendravaghela/cakephp-remember-me/coverage.svg?branch=master)](https://codecov.io/github/narendravaghela/cakephp-remember-me?branch=master)

This plugin provides a basic functionality to store user data in Cookies of your CakePHP applications for login and remember user in specific browser.

Read this [blog post](http://blog.narendravaghela.com/2015/01/cakephp-user-login-with-remember-me.html) for detailed example.

## Requirements

This plugin has the following requirements:

* CakePHP 3.0.0 or greater.
* PHP 5.4.16 or greater.

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

```
composer require narendravaghela/cakephp-remember-me
```

After installation, [Load the plugin](http://book.cakephp.org/3.0/en/plugins.html#loading-a-plugin)
```php
Plugin::load('RememberMe');
```
Or, you can load the plugin using the shell command
```sh
$ bin/cake plugin load RememberMe
```

## Usage

To use this, simply load the RememberMe component from this plugin into your AppController or UsersController.

```php
$this->loadComponent('RememberMe.RememberMe');
```

You can optionally pass the configuration options for this component.

```php
$this->loadComponent('RememberMe.RememberMe', [
    'cypherKey' => "17485937564892755682047369192734583655920926", // Random unuqie string to encrypt/decrypt data. If not set, default salt value of the application will be used.
    'cookieName' => "rememberme", // Name of the cookie.
    'period' => '14 Days' // Time period
]);
```

Here, the basic flow should something like this:
+ Find the user from the database
+ Validate
+ If user has selected "Remember me" checkbox, store the user data using this component.
+ Next time, when user (any user) visits the application, check the stored data using `getRememberedData()`.
+ Use the data returned by `getRememberedData()` and validate against the database and if everything goes well, create a session of the user and make him logged in.
+ If user manually logs out, simply delete the data from Cookie using `removeRememberedData()`.

### Remember data

In your `login` action or the action from where user logs into your application, use the `rememberData()` function and pass the required data of user being logged in.

```php
$this->RememberMe->rememberData("data@example.com"); // email address of user being logged in
// or you can use the array as well
$this->RememberMe->rememberData([
  'email' => 'foo@bar.com',
  'someUniqueKey' => 'someuniquevalue'
]);
```

### Get remembered data

Generally, in our `beforeFilter()` callback, we check whether user is logged in or not. Here, we can use `getRememberedData()` to retrieve the data that we have stored in our login action earlier.
If we find something, then we can check it against our user table to check whether there is a user or not.

```php
$isRemembered = $this->RememberMe->getRememberedData();

// code to check this data against database
// set the session
// ...
```

### Delete data

If you need to remove user data, just call the `removeRememberedData()` and it will delete the data from Cookie.

That is it.

## Reporting Issues

If you have a problem with RememberMe, please open an issue on [GitHub](https://github.com/narendravaghela/cakephp-remember-me/issues).
