<?php
// This is another page. This one shows details about the player, mainly the players gang

// Requires our autoloading and classes
require_once '__init.php';

// Handle user sign-in
User::i()->login();

// Echo the <head> into our document
Layout::i()->header();

if(User::i()->getGangID()){
    $Gang = SxApi::i()->getGang(User::i()->getGangID());

    if(!$Gang['success']){
        echo 'Error getting gang data: '.$Gang['error'];
        exit;
    }
}

?>
<body>

<?php
// Echo our navbar
Layout::i()->nav();
?>

<div class="text-center">
    <h1 class="display-4">Welcome <?=User::i()->getName()?></h1>
    <p class="lead"><?=User::i()->getGangID() ? 'Gang: '.$Gang['Name'] : 'You are not in a gang' ?></p>
    <h2>Gang members</h2>
    <table class="table container">
        <thead>
            <tr>
                <th>SteamID</th>
                <th>Rank</th>
            </tr>
        </thead>
        <tbody>
            <?php
                if(isset($Gang, $Gang['Members'])){
                    foreach($Gang['Members'] as $Key => $Item){
                        echo '<tr>';
                        echo '<td>'.$Item['SteamID'].'</td>';
                        echo '<td>'.$Item['Rank'].'</td>';
                        echo '</tr>';
                    }
                }
                else{
                    echo '<tr>';
                    echo '<td>No gang members</td>';
                    echo '<td></td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
</div>

<?php
// Echo our footer and scripts
Layout::i()->footer();
?>

<!-- Remember to close the body again! -->
</body>