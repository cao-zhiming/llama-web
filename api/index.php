<?php
echo '<!DOCTYPE html><html lang="en"><head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cao Zhiming\'s Llama AI</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.staticfile.org/bootstrap/5.3.2/css/bootstrap.min.css">
</head><body><div class="container mt-5">  
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="mb-4">Ask the Llama AI</h2>
            <form id="myForm" action="./index.php" method="post">
                <div class="form-group">
                    <input type="text" placeholder="Ask the AI assistant anything..." class="form-control" id="inputName" name="prompttext" required>
                </div><br>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
            <div id="response" class="mt-4"></div>
        </div>
    </div>
</div>
<script src="https://cdn.staticfile.org/jquery/3.7.1/jquery.slim.min.js"></script>
<script src="https://cdn.staticfile.org/bootstrap/5.3.2/js/bootstrap.min.js"></script>';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prompt = $_POST["prompttext"];
    // API endpoint URL
    $url = 'https://worker-czm-ai.caozm.workers.dev/';


    $jsonString = '{"messages": [{ role: "system", content: "You are a helpful assistant, you are MingAI. You can add emoji to your responses." },{ role: "user", content: "'.$prompt.'" }]';
    // Initialize cURL session
    $ch = curl_init($url);

    // Set cURL options
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonString);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($jsonString),
    ));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute cURL session and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'Curl error: ' . curl_error($ch);
    }

    // Close cURL session
    curl_close($ch);

    // Process the response
    echo '<script> document.getElementById("response").innerHTML = \'' . $response . '\';</script>';
}

echo '</body></html>';
?>
