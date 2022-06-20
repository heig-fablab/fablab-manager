<!--
Template found on https://freefrontend.com/css-forms/
Author : Håvard Brynjulfsen, 17/07/2020
Modified and adapted by : Tristan Lieberherr, 21/07/2021
Modified and adapted by : Alec Berney, 20/06/2022
-->
<!DOCTYPE html>
<html lang="en" class="html">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <style>
        @import url('https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&display=swap');

        *,
        *:after,
        *:before {
            box-sizing: border-box;
        }

        body {
            font-family: "DM Sans", sans-serif;
            line-height: 1.5;
            background-color: #f1f3fb;
            padding: 0 2rem;
        }

        img {
            max-width: 100%;
            display: block;
        }

        .card {
            margin: 2rem auto;
            display: flex;
            flex-direction: column;
            width: 100%;
            max-width: 425px;
            background-color: #FFF;
            border-radius: 10px;
            box-shadow: 0 10px 20px 0 rgba(#999, .25);
            padding: .75rem;
        }

        .action {
            margin-top: 2rem;
        }

        .action-button {
            font: inherit;
            font-size: 1.25rem;
            padding: 1em;
            width: 100%;
            font-weight: 500;
            background-color: dimgray;
            border-radius: 6px;
            color: #FFF;
            border: 0;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="card">
            <div>
                <img src="{{ asset('img/heig_2020.svg') }}" alt="" style="margin: 15%; margin-top: 20px; margin-bottom: 20px;">
            </div>
            <h2 style="text-align: center">
                Bienvenue sur la plateforme des demandes de travaux du FabLab
            </h2>
            <p style="text-align: center">
                <small>
                    Avant de continuer, merci de vous connecter depuis votre compte Switch AAI
                </small>
            </p>
            <div class="action">
                <form action="/shibboleth-login">
                    <button class="action-button">Se connecter</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>