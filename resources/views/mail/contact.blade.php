<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #ffffff;
            font-family: Arial, sans-serif;
            color: #000000;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 100%;
            max-width: 600px;
            border-top: 25px solid rgb(123, 61, 26);
            border-bottom: 25px solid rgb(123, 61, 26);
            background-color: #ffffff;
            text-align: center;
            box-sizing: border-box;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            font-size: 18px;
        }
        .header, .footer {
            padding: 10px 20px;
        }
        .content {
            padding: 20px;
        }
        .content p {
            margin: 0 0 10px;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 20px 0;
            color: #ffffff;
            background-color: rgb(123, 61, 26);
            border-radius: 25px;
            text-decoration: none;
            font-weight: bold;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <!-- Vous pouvez ajouter un logo ou une image d'en-tête ici -->
        </div>
        <div class="content">
            <p>Bonjour cher admin Matthieu25v6,</p>
            <p>Vous avez reçu un message venant du visiteur <strong>{{ $data['name'] }}</strong> (<a href="mailto:{{$data['email']}}" style="color: rgb(123, 61, 26);">{{ $data['email'] }}</a>).</p>
            <p>{{ $data['message'] }}</p>
            <a href="mailto:{{ $data['email'] }}" class="btn"> <span style="color: white">Répondre au message</span> </a>
            <p>Cordialement,</p>
        </div>
        <div class="footer">
            <!-- Vous pouvez ajouter des informations ou des liens de pied de page ici -->
        </div>
    </div>
</body>
</html>
