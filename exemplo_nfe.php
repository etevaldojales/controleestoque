<?php
include("config_inicio.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Generate NFe</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

    <h1>Generate NFe</h1>

    <form id="nfeForm">
        <label for="orderId">Order ID:</label>
        <input type="text" id="orderId" name="orderId" value="1"> <br><br>
        <button type="button" onclick="generateNFe()">Generate NFe</button>
    </form>

    <h2>Result:</h2>
    <pre id="result"></pre>

    <script>
        function generateNFe() {
            var orderId = $('#orderId').val();

            $.ajax({
                type: 'POST',
                url: 'gerar_enviar_nfe.php',
                data: { id: orderId },
                dataType: 'json',
                success: function(response) {
                    $('#result').text(JSON.stringify(response, null, 2));
                },
                error: function(xhr, status, error) {
                    $('#result').text('Error: ' + error);
                }
            });
        }
    </script>

</body>
</html>
