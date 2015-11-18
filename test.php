<?php

$commander = new Commander();
// create instance, handle command based on interface
$commander->addHandler(UserCommand::class, UserCommandHandler::class);
// use instance, handle command based on interface
$commander->addHandler(UserCommand::class, new UserCommandHandler());
// call callable and handle command
$commander->addHandler(UserCommand::class, function() {});
// call callable and handle command
$commander->addHandler(UserCommand::class, [$instance, 'method']);


// not yet ---------

// create an instance and call the register method based on the interface
$commander->registerHandler(UserCommandHandler::class);
// call the register method based on the interface
$commander->registerHandler($instance);

// ----------------

$result = $commander->dispatch($command);
