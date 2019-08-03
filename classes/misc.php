<?php
// This class contains all the things that don't really fit into other classes, but we still need to be accessible from everywhere
class Misc
{
    use Singleton;

    // Sanitize a string for use in whatever. Does NOT protect against SQL injections. Use prepared statements!
    public function cleanInput($str, $htmlspecialchars = true)
    {
        $str = trim($str);
        $str = stripslashes($str);
        if($htmlspecialchars){
            $str = htmlspecialchars($str);
        }
        return $str;
    }
}
