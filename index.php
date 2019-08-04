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

//Programs::i()->newProgram('ZiipenFM', 'Proin id mauris scelerisque, interdum purus in, tempor mauris. Donec elit leo, sollicitudin non ipsum eu, mattis fermentum enim. Nam aliquet dui ac odio semper, at varius', 'Ziipen & Peanut', 48)
?>

<div class="text-center">
    <h1 class="display-4">Velkommen til ZiipenFM</h1>


</div>

<?php
// Echo our footer and scripts
Layout::i()->footer();
?>

<!-- Adding the Config::i()->getVersion() thing makes caching way easier to deal with. In development mode, the version will be a randomized string on each visit, to completely bypass the cache -->
<script src="/assets/js/index.js?v=<?=Config::i()->getVersion()?>"></script>

<!-- Remember to close the body again! -->
</body>