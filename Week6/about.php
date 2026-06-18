<?php
// about.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Full page background */
        .about-section {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;

            background-image: url("./images/engine.jpg");
            background-size: cover;
            background-position: center;
            position: relative;
            color: #fff;
        }

        /* Dark overlay for readability */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0,0,0,0.5);
        }

        /* Content */
        .content {
            position: relative;
            max-width: 600px;
            padding: 20px;
        }

        h1 {
            font-size: 40px;
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            line-height: 1.6;
        }
    </style>
</head>
<body>

<div class="about-section">
    <div class="overlay"></div>

    <div class="content">
        <h1>About Us</h1>
        <p>
            Welcome to our platform. We are committed to delivering quality services,
            modern design, and a smooth user experience. Our goal is to build solutions
            that make life easier and more efficient.
        </p>
    </div>
</div>

</body>
</html>