<?php
// Adding the ../ since we're in a subdirectory now
require_once '../__init.php';

// Login the user
User::i()->login();

// Send the actual notification
echo json_encode(SxApi::i()->sendNotification(User::i()->getSteamID(), 'Test application', 'This notification is a test yes?'));