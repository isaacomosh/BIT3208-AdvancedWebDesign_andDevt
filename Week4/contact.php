<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
        }

        /* Background section */
        .contact-section {
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

        /* Dark overlay */
        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            height: 100%;
            width: 100%;
            background: rgba(0,0,0,0.6);
        }

        /* Content box */
        .content {
            position: relative;
            max-width: 500px;
            padding: 20px;
        }

        h1 {
            font-size: 40px;
            margin-bottom: 20px;
        }

        /* Social buttons */
        .socials {
            display: flex;
            justify-content: center;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .socials a {
            text-decoration: none;
            padding: 10px 18px;
            border: 1px solid #fff;
            color: #fff;
            border-radius: 25px;
            font-size: 14px;
            transition: 0.3s ease;
        }

        .socials a:hover {
            background: #fff;
            color: #000;
        }

        /* Hotline */
        .hotline {
            margin-top: 10px;
            font-size: 18px;
            border-top: 1px solid rgba(255,255,255,0.4);
            padding-top: 15px;
        }

        .hotline span {
            font-weight: bold;
            display: block;
            margin-top: 5px;
            font-size: 20px;
        }
    </style>
</head>
<body>

<div class="contact-section">
    <div class="overlay"></div>

    <div class="content">
        <h1>Contact Us</h1>

        <div class="socials">
            <a href="https://facebook.com" target="_blank">Facebook</a>
            <a href="https://instagram.com" target="_blank">Instagram</a>
            <a href="https://tiktok.com" target="_blank">TikTok</a>
        </div>

        <div class="hotline">
            Hotline
            <span>+254 700 000 000</span>
        </div>
    </div>
</div>

</body>
</html>