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
            font-family: Arial, Helvetica, sans-serif;
            margin: 0;
            padding: 0;
            position: relative;
            color: #333;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
            background-image: url('{{ asset('images/bg2.png') }}');
            background-size: cover;
            filter: blur(5px);
        }

        header {
            background-color: rgba(44, 62, 80, 0.7);
            color: #ecf0f1;
            text-align: left;
            padding: 3px 20px;
            box-sizing: border-box;
            position: relative;
            z-index: 1;
            margin: 50px;
            border-radius: 20px;
            padding-top: 20px;
            padding-bottom: 20px;
        }

        #login-container {
            position: absolute;
            top: 2em;
            right: 2em;
        }

        #login-link {
            color: #ecf0f1;
            text-decoration: none;
            margin-right: 20px;
        }

        #about-link {
            color: #ecf0f1;
            text-decoration: none;
            margin-right: 20px;
        }

        #welcome-link {
            color: #ecf0f1;
            text-decoration: none;
            margin-right: 20px;
        }

        section {
            max-width: 600px;
            margin: 2em auto;
            padding: 2em;
            float: left;
            padding-left: 200px;
            padding-top: 10px;
            position: relative;
            z-index: 1;
        }

        section img {
            border-radius: 50%;
            /* Make the image circular */
            max-width: 100%;
            /* Ensure the image doesn't overflow its container */
        }

        h1 {
            color: #ecf0f1;
            font-size: 33px;
            margin: 0;
        }

        h2 {
            color: #f5eeee;
            font-size: 55px;
            margin-top: 20px;
        }

        h2 span {
            color: #3498db;
        }

        p {
            line-height: 1.6em;
            font-size: 25px;
            margin-top: 15px;
        }

        .cta-button {
            display: inline-block;
            background-color: #3498db;
            color: #ecf0f1;
            padding: 15px 30px;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
            font-size: 20px;
            margin-top: 20px;
        }

        .cta-button:hover {
            background-color: #2980b9;
        }

        section h3 {
            color: #3498db;
            font-size: 25px;
        }

        section p {
            line-height: 1.6em;
            font-size: 22px;
            margin-top: 15px;
            color: #ecf0f1;
        }
        section ul {
            color: #ecf0f1;
            list-style-type: none;
            padding-left: 1;
            font-size: 20px;
        }
        @media (max-width: 768px) {
            header {
                text-align: center;
            }

            #login-container {
                position: static;
                margin-top: 20px;
            }

            #login-link {
                display: block;
                margin: 10px 0;
            }

            #about-link {
                display: block;
                margin: 10px 0;
            }

            #welcome-link {
                display: block;
                margin: 10px 0;
            }

            h1 {
                font-size: 24px;
            }

            @media (max-width: 768px) {
                section {
                    max-width: 90%;
                    margin: 2em auto;
                    padding: 2em;
                    float: none;
                    padding-left: 20px;
                    padding-top: 20px;
                }

                h2 {
                    font-size: 36px;
                }

                h2 span {
                    font-size: 24px;
                }

                p {
                    font-size: 18px;
                }

                .cta-button {
                    font-size: 16px;
                    padding: 10px 20px;
                    margin-top: 15px;
                }
            }
        }
    </style>
</head>

<body>
    <header>
        <h1>Mabini Health Center</h1>
        <div id="login-container">
            <a id="welcome-link" href="/">Home</a>
            <a id="about-link" href="/about">About</a>
            @auth
                <a id="login-link" href="{{ route('home') }}">Dashboard</a>
            @else
                <a id="login-link" href="{{ route('login') }}">Login</a>
            @endauth
        </div>
    </header>

    <section>
        <h2>All about, <span> Mabini Health Center</span></h2>
        <p>
            The Mabini Health Center Office is a Hospital located at 3W9R+M7M, Mabini, Pangasinan PH.
            The Mabini Health Center is dedicated to providing quality healthcare services to the community.
            Our mission is to promote the well-being of individuals and families through accessible and
            comprehensive medical care. With a team of experienced healthcare professionals, we strive to
            create a healthy and supportive environment for everyone we serve.
        </p>
        <h3>What Mabini Health Center Offers:</h3>
        <ul>
            <li>Primary Care Services</li>
            <li>Specialized Medical Treatments</li>
            <li>Preventive Healthcare Programs</li>
            <li>Health Education and Counseling</li>
            <!-- Add more items as needed -->
        </ul>
    </section>

    <section>
        <img src="{{ asset('images/logo.png') }}" alt="Mabini Health Center Logo">
    </section>
</body>

</html>
