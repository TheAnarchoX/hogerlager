<?php
$file = basename(__FILE__);
require ('App\DB\Connection.php');
require ('App\Models\User.php');
use App\Models\User;
$users = User::all();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Jim de Vries"/>
    <meta name="description" content="Starfish"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <title>Hoger Lager</title>
</head>
<body>
<?php include 'partials/navbar.php' ?>
    <div class="container">
        <div class="jumbotron" style="color: white">
            <h1 class="display-3">Hoger Lager!</h1>
            <p class="lead">Een simpel spelletje hoger lager</p>
            <hr class="my-4">
            <p>Je hebt 3 pogingen om het getal te raden</p>
        </div>
        <h2 class="text-center">Resultaten:</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Naam</th>
                    <th>Pogingen</th>
                </tr>
            </thead>
            <tbody>
            <?php if($users) {?>
                <?php foreach ($users as $user) { ?>
                    <tr>
                        <td><?php echo $user->name; ?></td>
                        <td><?php echo $user->tries; ?></td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="2">Geen resultaten</td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
<script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>