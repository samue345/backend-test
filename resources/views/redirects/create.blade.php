<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('redirects.store') }}" method="POST">
       @csrf
      <input type="text" name="url_destino" id="url_destino" placeholder="digite a url de destino" required >
        <button type="submit">Criar redirect</button>
    </form>
    
</body>
</html>