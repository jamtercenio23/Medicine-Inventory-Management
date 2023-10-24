<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mabini Health Center Medicine Inventory Management</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url("/public/images/bg.jpg");
            background-size: cover; /* Make the background image cover the entire page */
            color: #333;
        }

        header {
            background-color: #2c3e50;
            color: #ecf0f1;
            text-align: center;
            padding: 2px;
            position: relative;
        }

        #login-container {
            position: absolute;
            top: 1em;
            right: 1em;
        }

        #login-link {
            color: #ecf0f1;
            text-decoration: none;
            margin-right: 20px;
        }

        section {
            max-width: 800px;
            margin: 2em auto;
            padding: 2em;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #ecf0f1;
        }

        p {
            line-height: 1.6em;
        }

        .cta-button {
            display: inline-block;
            background-color: #3498db;
            color: #ecf0f1;
            padding: 0.8em 1.5em;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .cta-button:hover {
            background-color: #2980b9;
        }

        footer {
            background-color: #34495e;
            color: #ecf0f1;
            text-align: center;
            padding: 1em;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>
    <header>
        <h1>Welcome to Mabini Health Center</h1>
    </header>

    <section>
        <h2>Your Health and Wellness at the Heart of Our Service</h2>
        <p>
            At Mabini Health Center, we are committed to providing you with high-quality healthcare services.
            Our state-of-the-art facilities and dedicated medical professionals are here to ensure your well-being.
        </p>

        <p>
            Explore our services and experience healthcare like never before. We offer:
            <ul>
                <li>Comprehensive medical care</li>
                <li>Experienced healthcare professionals</li>
                <li>Well-equipped facilities</li>
                <li>Personalized treatment plans</li>
            </ul>
        </p>

        <a href="{{ route('login') }}" class="cta-button">Get Started</a>
    </section>

    <footer>
        <p>Contact us at <a href="mailto:info@mabinihealthcenter.com">info@mabinihealthcenter.com</a></p>
    </footer>
</body>
</html>
