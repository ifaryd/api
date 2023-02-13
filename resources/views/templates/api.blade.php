<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<h1>liste des maladues</h1>

{% for i in data %}
    <h4>{{ i.sous_titre }}</h4>
{% endfor %}
</body>
</html>






