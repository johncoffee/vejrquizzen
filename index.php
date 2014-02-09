<?php
$devMode = $_SERVER['REMOTE_ADDR'] === "::1";
session_start();
?>
<!DOCTYPE html>

<html>
    <head>     
        <title></title>
        <meta charset="UTF-8">
        <?php if ($devMode):
            // dev external stylesheets ?>
            <link href="bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <?php else:
            // prod external stylesheets ?>        
            <link href="//netdna.bootstrapcdn.com/bootstrap/3.1.0/css/bootstrap.min.css" rel="stylesheet">
        <?php endif; ?>

        <?php
        // write stylesheet links
        
        foreach (array("css") as $directory) {
            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
            $files = array();
            while ($it->valid()) {
                $filename = $it->getSubPathName();
                //if (strpos($filename, ".js") && $filename != $app_file) {
                if (false !== stripos($filename, ".css")) {
                    //echo $filename;
                    $files[] = $directory . "/" . $filename;
                }

                $it->next();
            }

            foreach ($files as $filename) {
                echo '<link href="' . str_replace('\\', '/', $filename) . '?socasf0205b" rel="stylesheet">';
            }
        }
        ?>

    </head>
    <body ng-app="myApp">        
        <div class="container" ng-include="'app/partials/quiz.html'"></div>


<?php if ($devMode):
            // dev libs ?>
            <!--<script src="bower_components/jquery/jquery.js?socasf0205b"></script>-->
            <!--<script src="bower_components/jquery.scrollTo/jquery.scrollTo.js"></script>-->           
            <script src="bower_components/lodash/dist/lodash.js"></script>
            <script src="bower_components/angular/angular.js?socasf0205b"></script>
            <!--<script src="bower_components/angular-route/angular-route.js?socasf0205b"></script>-->           
            <!--<script src="bower_components/lodash/dist/lodash.js"></script>-->                      
            <script src="bower_components/momentjs/moment.js"></script>           
<?php else:
            // prod libs ?>        
            <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.0/jquery.min.js"></script>-->       
            <!--<script src="bower_components/jquery.scrollTo/jquery.scrollTo.min.js?socasf0205b"></script>-->                       
            <script src="//cdnjs.cloudflare.com/ajax/libs/lodash.js/2.4.1/lodash.min.js"></script>           
            <script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.11/angular.min.js"></script>       
            <!--<script src="//ajax.googleapis.com/ajax/libs/angularjs/1.2.11/angular-route.js"></script>-->               
            <script src="bower_components/momentjs/min/moment.min.js?socasf0205b"></script>           
        <?php endif; ?>            

        <?php
        // write script tags or build js

        $buildfilename = "bin/build.js";

        if ($devMode && !isset($_GET['prodjs'])) {

            $directory = "app";

            $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
            $files = array();

            while ($it->valid()) {
                $filename = $it->getSubPathName();
                //if (strpos($filename, ".js") && $filename != $app_file) {
                if (false !== stripos($filename, ".js") && false === stripos($filename, ".json")) {
                    //echo $filename;
                    $files[] = $directory . DIRECTORY_SEPARATOR . $filename;
                }

                $it->next();
            }

            if (isset($_GET['buildjs'])) {
                $buildfilename_handle = fopen($buildfilename, 'w');
                
                if ($buildfilename_handle !== false) {

                    foreach ($files as $filename) {
                        $jsContent = "// $filename \n\n" . file_get_contents(str_replace("\\", "/", $filename)) . "\n\n";
                        fwrite($buildfilename_handle, $jsContent);
                    }
                    
                    fclose($buildfilename_handle);
                }
                
                echo "<script src=\"$buildfilename\"></script>\n";                
            } 
            else {
                foreach ($files as $filename) {
                    echo '<script src="' . str_replace('\\', '/', $filename) . "\"></script>\n";
                }
            }
        } 
        else {
            echo '<script src="/' . $buildfilename . "?socasf0205b\"></script>\n";
        }
        ?>  
                               
         <?php
        // write template tags. Must be inside ng-app

        $directory = "app/partials";
        
        $it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
        
        $files = array();
        
        while ($it->valid()) {
            $filename = $it->getSubPathName();
            //if (strpos($filename, ".js") && $filename != $app_file) {
            if (false !== strpos($filename, ".html")) {
                //echo $filename;
                $files[] = $directory . "/" . $filename;
            }
            $it->next();
        }

        // .module call must happen before defining services!
        foreach ($files as $filename) {
            echo '<script type="text/ng-template" id="'.$filename.'">'."\n". file_get_contents($filename) ."\n</script>\n";
        }

        ?>
        
    </body>
</html>



