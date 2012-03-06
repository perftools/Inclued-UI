<?php
//If you just want to get stuff done, you only need to edit these constants

//Where is inclued storing the dumps, configured in php.ini
define('INCLUED_DIR', '/tmp/inclued/'); //With a trailing slash if you would be so kind

//Where can this script store temp files and images
define('TEMP_STORAGE', '/tmp/inclued_temp/'); //With a trailing slash if you would be so kind

define('GENGRAPH_PATH', '/usr/local/lib/php/gengraph.php');

define('DOT_PATH', '/usr/local/bin/dot');

define('PHP_PATH', '/usr/local/bin/php');

define('DATE_FORMAT', 'M d  h:i:s');

if (isset($_GET['f']))
{
    //We're loading something
    
    $filename = base64_decode($_GET['f']);
    $inputPath = INCLUED_DIR . $filename;
    $outputPath = TEMP_STORAGE . $filename;
    
    //If this exists from some previous run, that's just super
    if (file_exists($outputPath . ".png"))
    {
        sendit($outputPath . ".png");
        exit;
    }
    //Two step process, run it through gengraph, then dot
    //Gengraph
    $cmd1 = PHP_PATH . " " . GENGRAPH_PATH . " -t includes -i $inputPath -o {$outputPath}.tmp";
    $result1 = shell_exec($cmd1);
    
    //dot
    $cmd2 = DOT_PATH . " -Tpng -o {$outputPath}.png {$outputPath}.tmp";
    $result2 = shell_exec($cmd2);
    
    if (file_exists($outputPath . ".png"))
    {
        sendit($outputPath . ".png");
    }else {
        echo "Well, something went wrong. there's no {$outputPath}.png<br />";
        echo "Command 1: $cmd1  -> $result1<br />";
        echo "Command 2: $cmd2  -> $result2<br />";
    }
 //dot -Tpng -o inclued.png inclued.out.dot
   
}

function sendit($path)
{
    if (isset($_GET['d']))
    {
        //Download as attachment
        $base = basename($path);
        header('Content-Type: image/png');
        header('Content-Disposition: attachment; filename="' . $base . '"');
        readfile($path);
    }else {
        //Simply display
        header('Content-Type: image/png');
        readfile($path);
    }
}

?>


<table>
    <thead>
        <tr>
            <th>URI</th><th>Request Time</th><th>Dump Size</th><th>Download</th>
        </tr>
    </thead>
    <tbody>
        
<?php
$a = new DirectoryIterator(INCLUED_DIR);
$requests = array();
foreach($a as $b)
{
    if ($b->isFile() == false)
    {
        continue;
    }
    $c = unserialize(file_get_contents($b->getPathname()));
    if (isset($c['request']['REQUEST_URI']))
    {
        $requests[] = array("uri" => $c['request']['REQUEST_URI'], "time" => $c['request']['REQUEST_TIME'], "filename" => base64_encode($b->getFilename()), "size" => $b->getSize());
        
    }
}

foreach($requests as $request)
{
    $time = date(DATE_FORMAT, $request['time']);
    echo "<tr><td><a href=\"?f={$request['filename']}\">{$request['uri']}</a></td><td>{$time}</td><td>{$request['size']}</td><td><a href=\"?f={$request['filename']}&d=1\">{$request['uri']}</a></tr>";
}
?>
    </tbody>
</table>