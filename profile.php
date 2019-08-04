<?php
// This is the index/front page of your app. This is what will be shown to the user upon startup

// Requires our autoloading and classes
require_once '__init.php';

// Handle user sign-in
User::i()->login();

// Echo the <head> into our document
Layout::i()->header();

if(!$_GET['id']){
    header('Location: /');
}

?>
<body>

<?php
// Echo our navbar
Layout::i()->nav();

$res = User::i()->getUserData($_GET['id']);
?>

<div class="container" style="margin-top: 1em;">
  <div class="card responsive mb-3">
    <div class="card-body" style="background-color: #f6f6f6;">
      <div class="row mt-3">

        <!-- Billede -->
        <div class="col-lg-2 ml-4">

            <img src="<?=Steam::i()->getProfilePicture($res['SteamID'])?>" class="rounded-circle" style="max-width: 128px; max-height: 128px;">
            <br><br>  
        </div>

        <div class="col-lg-9">
          <!-- Steam navn -->
          <h5 class="card-title">Brugernavn</h5>
          <input type="email" class="form-control mb-4" name="steamNameBuyer" aria-describedby="steamNamehelp" value="<?=$res['Name']?>" readonly>

          <h5 class="card-title">SteamID</h5>
          <input type="email" class="form-control mb-4" name="steamNameBuyer" aria-describedby="steamNamehelp" value="<?=$res['SteamID']?>" readonly>

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