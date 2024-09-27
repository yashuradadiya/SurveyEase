<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Copy Text Example</title>
</head>
<body>

    <!-- Input field containing text to copy -->
    <input type="text" value="Text to be copied" id="textToCopy">
    
    <!-- Button to trigger the copy function -->
    <button onclick="copyText()">Copy Text</button>

    <!-- JavaScript for copying text -->
    <script>
        function copyText() {
            // Get the input field
            var copyText = document.getElementById("textToCopy");

            // Select the text field
            copyText.select();
            copyText.setSelectionRange(0, 99999);  // For mobile devices

            // Copy the text inside the text field
            document.execCommand("copy");

            // Alert the copied text (optional)
            alert("Copied the text: " + copyText.value);
        }
    </script>

</body>
</html>
