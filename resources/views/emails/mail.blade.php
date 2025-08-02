<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>{{ $sujet ?? 'Notification' }}</title>
    <style>
        body {
            background-color: #f4f4f4;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background-color: #ffffff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .email-header {
            background-color: #248a44;
            color: #ffffff;
            padding: 20px;
            text-align: center;
        }
        .email-body {
            padding: 30px;
            color: #333333;
        }
        .email-footer {
            background-color: #f1f1f1;
            text-align: center;
            padding: 15px;
            font-size: 13px;
            color: #777777;
        }
        .btn {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #248a44;
            color: #ffffff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn:hover {
            background-color: #084298;
        }
    </style>
</head>
<body>
<div class="email-container">
    <div class="email-header">
        <h2>{{ $subject ?? 'Notification' }}</h2>
    </div>
    <div class="email-body">
        <p>Bonjour <strong>{{ $user->nom }}</strong>,</p>

        <p>{!! nl2br(e($contenu)) !!}</p>

        {{-- Optionnel : un bouton --}}
         <a href="{{ $url ?? '#' }}" class="btn">Voir plus</a>
    </div>
    <div class="email-footer">
        © {{ date('Y') }} {{ config('app.name') }}. Tous droits réservés.
    </div>
</div>
</body>
</html>
