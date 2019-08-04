<?php
// This class contains all the things we're gonna be using in our HTML more than once. Basic things like the header, navbar and footer.
// You can, of course, remove any of these, if you do not need them
class Layout
{
    use Singleton;

    public function header()
    {
        ?>
        <head>
            <link rel="stylesheet" type="text/css" href="/vendor/bootstrap-4.3.1/bootstrap.min.css">

            <!-- Adding the Config::i()->getVersion() thing makes caching way easier to deal with. In development mode, the version will be a randomized string on each visit, to completely bypass the cache -->
            <link rel="stylesheet" type="text/css" href="/assets/css/app.css?v=<?=Config::i()->getVersion()?>">
        </head>
        <?php
    }

    public function nav()
    {
        ?>
        <nav class="navbar navbar-expand-md navbar-dark bg-dark mb-4">
            <a class="navbar-brand" href="/">ZiipenFM</a>

            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/">Hjem</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/programs.php">Programmer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/team.php">Team</a>
                </li>
            </ul>
            <div class="nav-item dropdown">
                <a class="dropdown-toggle mr-3" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false" style="color: white; text-decoration: none;"> Logget ind som: <?=User::i()->getName()?></a>
                <div class="dropdown-menu">

                    <!-- Profil -->
                    <a class="dropdown-item" href="profile.php?id=<?=User::i()->getSteamID()?>">Min profil</a>

                    <!-- Admin tjek -->
                    
                    <!--    <a class="dropdown-item" href="user.php"></i> Mine Reklamer</a>-->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="devreq.php">Udviker</a>
                    <a class="dropdown-item"href="dashboard.php">Dashboard</a>
                </div>
            </div>
        </nav>
        <?php
    }

    public function footer()
    {
        ?>
            <footer class="mt-auto text-center text-muted">
                <!-- Didn't know what to add in this footer so whatever -->
                <p class="fixed-bottom">© Foks Corp 2019 - Version: <?=Config::i()->getVer()?></p>
            </footer>
            <script src="/vendor/jquery-3.4.1/jquery.min.js"></script>
            <script src="/vendor/popper-1.14.7/popper.min.js"></script>
            <script src="/vendor/bootstrap-4.3.1/bootstrap.min.js"></script>
        <?php
    }

    public function error($Title, $Message = null)
    {
        echo '<head></head>';
        echo '<body style="text-align: center;">';

        echo '<h1>'.$Title.'</h1>';
        echo '<p>'.(isset($Message) ? $Message : 'No message provided').'</p>';

        echo '</body>';
    }
}