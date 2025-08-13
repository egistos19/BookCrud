<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hoşgeldiniz</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; background: #fff; margin: auto; padding: 20px; border-radius: 8px; }
        h1 { color: #333; }
        p { font-size: 16px; color: #555; }
        .btn {
            display: inline-block;
            padding: 12px 20px;
            background-color: #91cafa;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-top: 15px;
        }
        .btn:hover { background-color: #78bffa; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Hoşgeldiniz {{ $user->name }}</h1>
        <p>İlk kitabınızı eklemeye hemen başlayabilirsiniz. Aşağıdaki butona tıklayın.</p>
        <a href="{{ route('books.create') }}" class="btn"> Kitap Oluştur</a>
    </div>
</body>
</html>

