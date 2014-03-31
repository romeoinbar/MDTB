<!DOCTYPE html>
<html lang="en-US">
    <head>
        <meta charset="utf-8">
    </head>
    <body>
        <h3>{{ trans('main.activate email 1') . ', ' . $username }}!</h3>
 
        <p>
       	  Pour compléter l'inscription s'il vous plaît cliquez sur le lien ci-dessous.
       	  <br>
       	  <a href="{{ URL::to("activate/{$id}/{$code}") }}">{{ URL::to("activate/{$id}/{$code}") }}</a>
        </p>
    </body>
</html>
