<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <style>
        a{
            color: black;
            text-decoration: none
        }
        a:hover{
            color: #ccc
        }
        .flex{
            display:flex;
        }
    </style>
</head>
<body>
    <article>
        <h1>Listagem de redirects</h1>
        @foreach ($registers_redirects as $redirect)
        <a  href="{{ route('r.redirect', $redirect->code) }}">
        <section>
                <p>Código: {{ $redirect->code }}</p>
                <p>Status: {{ $redirect->status }}</p>
                <p>Data de Atualização: {{ $redirect->updated_at }}</p>
                <p>Data de Criação: {{ $redirect->created_at }}</p>
                <p>Data de Acesso: {{ $redirect->date_access }}</p>
                <p>URL de Destino: {{ $redirect->url_destino }}</p>
       </section>
       </a>
       <footer class="flex">
        <button><a href="{{ route('redirects.stats', $redirect->code) }}">Estatísticas</a></button>
        <button><a href="{{ route('redirects.logs', $redirect->code) }}">Logs</a></button>
        <button><a href="{{ route('redirects.edit', $redirect->code) }}">atualizar</a></button>
        <button>Deletar</button>
       </footer>
       <hr> 
       

       @endforeach
    </article>
    
</body>
</html>