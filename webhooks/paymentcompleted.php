<?php
// Adding the ../ since we're in a subdirectory now
require_once '../__init.php';

// We are not logging in any user in any webhook usually, so we won't be adding the user->login thing

// Validate the webhook call
SxApi::i()->validateWebhookCall();

/*
    For this hook, we will be expecting to get the following POST parameters
    steamid - The steamid of the player who sent the money
    amount - The amount of money received. You should validate that this amount is the same as you requested, since the amount the player chooses to buy is selected on the client
    requesttoken - The token you provided to the moneyRequest function. In this example, it will be MyPaymentID
*/
if (isset($_POST['steamid'], $_POST['amount'], $_POST['requesttoken'])) { // If the required parameters are set
    // In this example we will just create a file called requests.txt, and append a line to it, containing the details about the transaction. You would probably insert this into some database instead.
    file_put_contents('requests.txt', date('Y-m-d H:i:s') . ': ' . Misc::i()->cleanInput($_POST['amount']) . ' recieved from ' . Misc::i()->cleanInput($_POST['steamid']) . ' with request token ' . $_POST['requesttoken'] . PHP_EOL, FILE_APPEND);
} else { // If the required parameters was not set
    error_log(json_encode($_POST));
    exit;
}
