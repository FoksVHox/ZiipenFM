<?php
// This is the index/front page of your app. This is what will be shown to the user upon startup

// Requires our autoloading and classes
require_once '__init.php';

// Handle user sign-in
User::i()->login();

// Echo the <head> into our document
Layout::i()->header();

?>
<body>

<?php
// Echo our navbar
Layout::i()->nav();

// Check if get isset
if(!isset($_GET['pg'])){
    header('Location: /');
} else {
    $id = hex2bin($_GET['pg']);
}

$res = Programs::i()->getProgramData($id)
?>

<div class="text-center">
    <h1 class="display-4"><?=$res['Name']?></h1>


</div>

<div class="container mt-5 mb-5">
    <div class="container-fluid">
    
        <div class="row">
            <div class="col-md-10">

            <div class="card responsive mb-3">
                <div class="card-body" style="background-color: #f6f6f6;">
                    <img src="assets/img/img<?=$res['Icon']?>.jpg" alt="" style="max-width: 850px;">

                    <p><?=nl2br($res['Description'])?></p>
                </div>
            </div>
            
            </div>

            <div class="col-md-2">  

                <div class="card" style="width: 18rem;">
                    <div class="card-header">
                        Informaton
                    </div>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">Vært: <?=$res['Host']?></li>
                        <li class="list-group-item">Sendes: <?=$res['When']?></li>
                        <li class="list-group-item"><h4><span class="badge badge-success">LIVE</span></h4></li>
                    </ul>
                </div>

            </div>
        </div>

    </div>
</div>

<?php
// Echo our footer and scripts
Layout::i()->footer();
?>

<!-- Adding the Config::i()->getVersion() thing makes caching way easier to deal with. In development mode, the version will be a randomized string on each visit, to completely bypass the cache -->
<script src="/assets/js/index.js?v=<?=Config::i()->getVersion()?>"></script>

<!-- Remember to close the body again! -->
</body>