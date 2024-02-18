<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="{{ route('redirects.update', $redirect->code) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="text" name="url_destino" placeholder="Digite a URL de destino">
    <label for="status">Status</label>
    <select name="status" id="status">
        <option value=""></option>
        <option value="0">0</option>
        <option value="1">1</option>
    </select>
    <button type="submit">Atualizar Redirect</button>
</form>
    
</body>
</html>