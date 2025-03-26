<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Login</title>
    <!-- Include only the essential CSS -->
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 500px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
        }
        button:hover {
            background-color: #45a049;
        }
        .status {
            margin-top: 20px;
            padding: 10px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Test Login</h2>
        <div id="status"></div>
        
        <form id="loginForm">
            <div class="form-group">
                <label for="username">Email:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="pass">Password:</label>
                <input type="password" id="pass" name="pass" required>
            </div>
            
            <button type="submit">Login</button>
        </form>
    </div>

    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    
    <script>
        $(document).ready(function() {
            $("#loginForm").on("submit", function(e) {
                e.preventDefault();
                
                // Clear previous status
                $("#status").removeClass("success error").html("");
                
                // Get form data
                var formData = $(this).serialize();
                
                // Display loading message
                $("#status").html("Logging in...").show();
                
                // Make AJAX request
                $.ajax({
                    type: "POST",
                    url: "../query/loginExe.php",
                    data: formData,
                    dataType: "json",
                    success: function(response) {
                        console.log("Response:", response);
                        
                        if (response.res === "success") {
                            $("#status").addClass("success").html("Login successful! Redirecting...");
                            setTimeout(function() {
                                window.location.href = "../home.php";
                            }, 1500);
                        } else if (response.res === "invalid") {
                            $("#status").addClass("error").html("Invalid email or password. Please try again.");
                        } else {
                            $("#status").addClass("error").html("An error occurred. Please try again.");
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                        console.log("Response Text:", xhr.responseText);
                        $("#status").addClass("error").html("Server error. Please try again later.");
                    }
                });
            });
        });
    </script>
</body>
</html> 