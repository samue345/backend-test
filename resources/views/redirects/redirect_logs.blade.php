<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<main>
<table>
    <thead>
        <tr>
            <th>Detalhes do Redirecionamento</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <strong>User Agent:</strong> {{ $redirect->user_agent }}<br>
                <strong>URL Destino:</strong> {{ $redirect->url_destino }}<br>
                <strong>IP:</strong> {{ $redirect->ip_request }}<br>
                <strong>Referência do Header:</strong> {{ $redirect->header_refer ?: 'N/A' }}<br>
                <strong>Data de Acesso:</strong> {{ $redirect->date_access }}<br>
                <strong>Data de Criação:</strong> {{ $redirect->created_at }}<br>
                <strong>Data de atualização:</strong> {{ $redirect->updated_at }}<br>
                <strong>Status:</strong> {{ $redirect->status ? 'Ativo' : 'Inativo' }}<br>
            </td>
        </tr>
    </tbody>
</table>
</main>
<footer>
    <button><a href="{{ route('redirects.stats', $redirect->code) }}">Estatisticas</a></button>
    <button>atualizar</button>
    <button>Deletar</button>
</footer>

</body>
</html>