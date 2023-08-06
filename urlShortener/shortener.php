<?php

function shortenUrl($url, $apiKey) {
    $apiUrl = 'https://api.rebrandly.com/v1/links';

    $data = array(
        'destination' => $url,
        'domain' => array('fullName' => 'rebrand.ly')
    );

    $headers = array(
        'Content-Type: application/json',
        'apikey: ' . $apiKey
    );

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $responseData = json_decode($response, true);

    if (isset($responseData['shortUrl'])) {
        return $responseData['shortUrl'];
    } else {
        return false;
    }
}

    // Usage example
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "url_shortener_db";

    $dsn = "mysql:host=$host;dbname=$dbname";
    $con = new PDO($dsn, $user, $password);
    if(isset($_GET["enter"])){
        $apiKey = 'ff4e91fb93fd40eaac77ed83b9e9dc13';
        $urlToShorten = $_GET["url"];
        $shortUrl = shortenUrl($urlToShorten, $apiKey);
    
        if ($shortUrl) {
            // echo 'Shortened URL: ' . $shortUrl;
            $sql = "INSERT INTO url(shorten_url, orig_url) VALUES(?,?)";
            $pst = $con->prepare($sql);
            $pst->execute([$shortUrl,$urlToShorten]);
            $rowCount = $pst->rowCount();
            if($rowCount>0){
                header("Location: index.php?msg=URL Added");
            }
            
        } else {
            header("Location: index.php?msg=Failed to shorten URL");
        }
    }
    

?>