<?php
// Adding the ../ since we're in a subdirectory now
require_once '../__init.php';

// Login the user
User::i()->login();

echo json_encode(SxApi::i()->giveMoney(User::i()->getSteamID(), 100));