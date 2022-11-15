<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NMAP</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form action="<?=$_SERVER['PHP_SELF']?>" method="post">
        <h1>Target IP or range</h1><h3>(ex. 10.127.10.12 (single) or 10.127.0.0-255 (network))</h3>
        <input type="text" name="target" id="">
        <h1>Scan Technique</h1>
            <select name="scan_techn" id="">
                <option value="0">SYN (Standard)</option>
                <option value="1">CONNECT()</option>
                <option value="2">ACK</option>
                <option value="3">Window</option>
                <option value="4">Maimon</option>
                <option value="5">IP Protocol</option>
            </select><br/><br/>
            <label class="container">
                &emsp; &emsp; Enable OS Detection
                <input class="checkbox" type="checkbox" name="scan_ops[]" id="" value="0"/>
                <span class="checkmark"></span>
            </label><br/><br/>
        <input type="submit" value="Enter" name="submit"/>
    </form><br/>
    <hr/>
    <?php
    if (isset($_POST['submit'])) {   

        // Get target(s)
        $target=$_POST['target'];

        // Get scan technique
        $scan_types = array ("-sS","-sT","-sA","-sW","-sM","-sO");
        $scan_type = $scan_types[$_POST['scan_techn']];

        // Check if OS Scanning is wanted
        $os_enable = '';
        if (!$_POST['scan_ops'] == 0)
            $os_enable = " -A";

        // Put together command and run
        $exec = "nmap " . $target . " " . $scan_type . $os_enable . " --privileged -oX scan.xml";
        shell_exec($exec);

        // Get info from file
        $xml = simplexml_load_file("scan.xml") or die("Error: Cannot create object");

        // Function get_data() collects all the data from $xml and displays in readable format
        function get_data($xml, $exec) {
            foreach ($xml->host as $host) {

                echo "<div>";
                // Get target IP
                echo "<h4>Command</h4>" . $exec;
                echo "<h4>Target</h4>";
                if ($host->address['addrtype']=='ipv4')
                    echo "IP Address: " . $host->address['addr'] . "<br/>";
                    echo "Name: " . $host->hostnames->hostname['name'] . "<br/>";

                // Get OS info
                if($host->os->osmatch['name'])
                    echo "<h4>OS</h4>" . $host->os->osmatch['name'] . "&emsp;->&emsp;" . $host->os->osmatch->osclass['accuracy'] . "% accurate<br/>";

                // Get port info & display in a table
                echo "<h4>Open Ports</h4>";
                echo "<table border=1;>";
                echo "<th>Protocol</th><th>Port ID</th><th>Name</th><th>Product</th><th>OS Type</th>";
                foreach($host->ports->port as $port) {
                    echo "<tr>";
                    echo "<td>" . $port['protocol'] . "</td>";
                    echo "<td>" . $port['portid'] . "</td>";
                    echo "<td>" . $port->service['name'] . "</td>";
                    echo "<td>" . $port->service['product'] . "</td>";
                    echo "<td>" . $port->service['ostype'] . "</td>";
                    echo "</tr>";
                }
                echo "</table><br/>";
                echo "</div><hr/>";
            }
        }
        // Run
        echo "<h2 style='text-align:center;'>Scan Results</h2>";
        get_data($xml, $exec);
    } ?>

</body>
</html>