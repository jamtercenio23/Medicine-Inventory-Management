<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mabini Health Center Medicine Inventory Management</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrap.com/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        body {
            font-family: 'Nunito', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('{{ asset('images/bg2.png') }}');
            background-size: cover;
            color: #333;
        }

        header {
            background-color: rgba(44, 62, 80, 0.7);
            color: #ecf0f1;
            text-align: center;
            padding: 3px 0;
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
            max-width: 600px;
            margin: 2em auto;
            padding: 2em;
            background-color: rgba(255, 255, 255, 0.9);
            border-radius: 8px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
        }

        h1 {
            color: #ecf0f1;
            /* Adjusted text color */
            font-size: 36px;
        }

        h2 {
            color: #3498db;
            font-size: 28px;
            margin-top: 20px;
        }

        p {
            line-height: 1.6em;
            font-size: 18px;
            margin-top: 15px;
        }

        .cta-button {
            display: inline-block;
            background-color: #3498db;
            color: #ecf0f1;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 18px;
            margin-top: 20px;
        }

        .cta-button:hover {
            background-color: #2980b9;
        }

        footer {
            background-color: rgba(52, 73, 94, 0.7);
            color: #ecf0f1;
            text-align: center;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer a {
            color: #ecf0f1;
            text-decoration: none;
        }

        footer a:hover {
            text-decoration: underline;
        }

        @media (max-width: 768px) {
            section {
                max-width: 90%;

            .cta-button {
                font-size: 16px;
            }
        }
    </style>
</head>

<body>
    <header>
        <h1 >Welcome to Mabini Health Center</h1>
        <div id="login-container">
            @auth
                <a id="login-link" href="{{ route('home') }}">Dashboard</a>
            @else
                <a id="login-link" href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </header>

    <section>
        <h2>Your Health and Wellness at the Heart of Our Service</h2>
        <p>
            At Mabini Health Center, we are committed to providing you with high-quality healthcare services. Our
            state-of-the-art facilities and dedicated medical professionals are here to ensure your well-being.
        </p>

        <p>
            Explore our services and experience healthcare like never before. We offer:
        <ul>
            <p><strong>Comprehensive medical care</strong></p>
            <p><strong>Experienced healthcare professionals</strong></p>
            <p><strong>Well-equipped facilities</strong></p>
            <p><strong>Personalized treatment plans</strong></p>
        </ul>
        </p>

        <a href="{{ route('login') }}" class="cta-button">Get Started</a>
    </section>

    <footer>
        <p>Contact us at <a href="mailto:info@mabinihealthcenter.com">info@mabinihealthcenter.com</a></p>
    </footer>
</body>

</html>
