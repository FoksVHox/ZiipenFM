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
?>

<div class="container">
    <div class="container-fluid">
    
    <div class="text-center">
        <h1 class="display-4">Programmer</h1>
    </div>

    <div class="row mt-5">
        
            <div class="card ml-auto mr-auto mb-4" style="width: 20rem;">
                <img src="assets/img/img29.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">TechSex</h5>
                    <label class="text-muted">Vært: Johnson</label>
                    <br>
                    <p class="card-text">Proin id mauris scelerisque, interdum purus in, tempor mauris. Donec elit leo, sollicitudin non ipsum eu, mattis fermentum enim. Nam aliquet dui ac odio semper, at varius.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-block btn-primary">Se mere</a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="btn btn-block btn-success">Lyt live</a>
                        </div>
                    </div>
                </div>
            </div>
        
            <div class="card ml-auto mr-auto mb-4" style="width: 20rem;">
                <img src="assets/img/img46.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Nyheder</h5> <span class="badge badge-success">LIVE</span>
                    <label class="text-muted">Vært: Ziipen, Peanut</label>
                    <br>
                    <p class="card-text">Proin id mauris scelerisque, interdum purus in, tempor mauris. Donec elit leo, sollicitudin non ipsum eu, mattis fermentum enim. Nam aliquet dui ac odio semper, at varius.</p>
                    <div class="row">

                        <div class="col-md-6">
                            <a href="#" class="btn btn-block btn-primary">Se mere</a>
                        </div>
                        <div class="col-md-6">
                            <a href="https://coolassradio.tk/radio/8010/320kbps.mp3?1564873672" target="_blank" class="btn btn-block btn-success">Lyt live</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card ml-auto mr-auto mb-4" style="width: 20rem;">
                <img src="assets/img/img21.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Franzens hjørne</h5>
                    <label class="text-muted">Vært: Franzen, gæst</label>
                    <br>
                    <p class="card-text">Proin id mauris scelerisque, interdum purus in, tempor mauris. Donec elit leo, sollicitudin non ipsum eu, mattis fermentum enim. Nam aliquet dui ac odio semper, at varius.</p>
                    <div class="row">
                        <div class="col-md-6">
                            <a href="#" class="btn btn-block btn-primary">Se mere</a>
                        </div>
                        <div class="col-md-6">
                            <a href="#" class="btn btn-block btn-success">Lyt live</a>
                        </div>
                    </div>
                </div>
            </div>
        
       <!-- 
            <div class="card ml-auto mr-auto" style="width: 18rem;">
                <img src="assets/img/img2.jpg" class="card-img-top" alt="...">
                <div class="card-body">
                    <h5 class="card-title">Card title</h5>
                    <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
                    <a href="#" class="btn btn-primary">Go somewhere</a>
                </div>
            </div>
        -->

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