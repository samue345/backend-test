<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<table>
    <thead>
        <tr>
            <th>Detalhes do Redirecionamento</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <strong>User Agent:</strong> {{ $redirect_log->user_agent }}<br>
                <strong>URL Destino:</strong> {{ $redirect_log->url_destino }}<br>
                <strong>IP:</strong> {{ $redirect_log->ip_request }}<br>
                <strong>Referência do Header:</strong> {{ $redirect_log->header_refer ?: 'N/A' }}<br>
                <strong>Data de Acesso:</strong> {{ $redirect_log->date_access }}<br>
                
            </td>
        </tr>
    </tbody>
</table>


</body>
</html>