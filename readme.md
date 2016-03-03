# Simple command bus

[![Build Status](https://img.shields.io/travis/weew/php-commander.svg)](https://travis-ci.org/weew/php-commander)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/php-commander.svg)](https://scrutinizer-ci.com/g/weew/php-commander)
[![Test Coverage](https://img.shields.io/coveralls/weew/php-commander.svg)](https://coveralls.io/github/weew/php-commander)
[![Dependencies](https://img.shields.io/versioneye/d/php/weew:php-commander.svg)](https://versioneye.com/php/weew:php-commander)
[![Version](https://img.shields.io/packagist/v/weew/php-commander.svg)](https://packagist.org/packages/weew/php-commander)
[![Licence](https://img.shields.io/packagist/l/weew/php-commander.svg)](https://packagist.org/packages/weew/php-commander)

## Table of contents

- [Installation](#installation)
- [Introduction](#introduction)
- [Commands](#commands)
- [Registering command handlers](#registering-command-handlers)
- [Dispatching commands](#dispatching-commands)
- [Existing container integrations](#existing-container-integrations)

## Installation

`composer require weew/php-commander`

## Introduction

Commander is a simple message bus. It allows you to register command handlers and to dispatch commands. The main reason to use such an abstraction is to decouple components and dependencies. The caller never knows who will handle a command after all. All he knows is a set of contracts that both sides have to fulfill.

## Commands

A command has no restrictions. You can use almost everything as a command. It is recommended to create simple transfer/value objects and use them as commands. A command is basically a contract between the caller and the handler.

## Registering command handlers

To be able to dispatch commands to handlers, commander has to know who is responsible for each command. That is why you have have to register a handler for each command. A handler can be a callable or a class / instance that implements method `handle($command)`.

First let's create a very basic command, a handler and a result.

```php
class FooCommandHandler {
    public function handle($command) {
        return new FooResult();
    }
}

class FooCommand {
    public function __construct($foo, $bar) {}
}
class FooResult {}
```

Now comes the command registration.

```php
$commander = new Commander();
$commander->register(FooCommand::class, FooCommandHandler::class);
```

## Dispatching commands

After you have registered your commands and handlers you can invoke them from anywhere within you application.

```php
$result = $commander->dispatch(new FooCommand('foo', 'bar'));
```

## Existing container integrations

There is an integration available for the [weew/php-container](https://github.com/weew/php-container) container. See [weew/php-commander-container-aware](https://github.com/weew/php-commander-container-aware).
