<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Allert</title>
</head>
<body>

    <h1>Allert per Admin</h1>

    <p>
        Un nuovo film è stato creato! Controlla le sue info:
    </p>

    <p>-------------------------------------------------------</p>

    <p>
        <h2> {{$movie -> name}} - {{$movie -> year}} </h2> <br>
        <h3> {{$movie -> genre -> name}} - {{$movie -> cashOut}} </h3> <br>
        Con le seguenti Etichette:
        @foreach ($movie -> tags as $tag)
            <li> {{$tag.name}} </li>
        @endforeach

    </p>
    
</body>
</html>