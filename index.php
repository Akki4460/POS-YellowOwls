<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>YellowOwl POS</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html,
        body {
            background-color: #000;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 80vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links>a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #000;
            color: #636b6f;
        }

        .footer-content {
            max-width: 600px;
            margin: 0 auto;
        }
    </style>
</head>

<body>
    <div class="flex-center position-ref full-height">
        <div class="content">
            <div class="title m-b-md">
                The <span style="color:#F6C90E">YellowOwl</span> 
            </div>
            <!-- <p>POS</p> -->

            <div class="links">
			<!-- For more projects: Visit NetGO+  -->
                <a href="pos/admin/">Admin Log In</a>
                <a href="pos/cashier/">Cashier Log In</a>
                <!-- <a href="pos/customer">Customer Log In</a> -->
            </div>
        </div>
    </div>
    <footer>
        <div class="footer-content text-center text-muted">
            <p>&copy; 2024 The EagleWings. All rights reserved.</p>
            <p>Contact: eaglewingsads@gmail.com | +91 8483832208 / 8847727212</p>
        </div>
    </footer>
</body>


</html>