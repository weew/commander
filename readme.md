# Simple command bus

[![Build Status](https://img.shields.io/travis/weew/commander.svg)](https://travis-ci.org/weew/commander)
[![Code Quality](https://img.shields.io/scrutinizer/g/weew/commander.svg)](https://scrutinizer-ci.com/g/weew/commander)
[![Test Coverage](https://img.shields.io/coveralls/weew/commander.svg)](https://coveralls.io/github/weew/commander)
[![Version](https://img.shields.io/packagist/v/weew/commander.svg)](https://packagist.org/packages/weew/commander)
[![Licence](https://img.shields.io/packagist/l/weew/commander.svg)](https://packagist.org/packages/weew/commander)

## Table of contents

- [Installation](#installation)
- [Introduction](#introduction)
- [Commands](#commands)
- [Registering command handlers](#registering-command-handlers)
- [Dispatching commands](#dispatching-commands)
- [Existing container integrations](#existing-container-integrations)

## Installation

`composer require weew/commander`

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

There is an integration available for the [weew/container](https://github.com/weew/container) container. See [weew/commander-container-aware](https://github.com/weew/commander-container-aware).
