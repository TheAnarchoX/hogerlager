<?php
    $file = basename(__FILE__);
    require ('App\DB\Connection.php');
    require('App\Models\Game.php');
    require ('App\Models\User.php');

    use App\Models\Game;
    use App\Models\User;
    session_start();
    if(isset($_GET['success'])) {
        $msg = new stdClass();
        $msg->type = 'success';
        $msg->leader = 'Success !';
        $msg->body = 'Je resultaat is opgeslagen!';
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST') {
        try {
            $game = $_SESSION['game'];
            $tries = $game->try;
            $name = $_POST['name'];
            $user = new User($name, $tries);
            $user->store();
        } catch (Exception $exception) {
            var_dump($exception);
            die();
        }
        session_destroy();
        unset($_GET['guess']);
        header("Location: /?success=1");
        exit;
    }
    if(isset($_GET['reset'])) {
        session_destroy();
        unset($_GET['reset']);
        header("Location: /");
        exit;
    }
    if(isset($_SESSION['game'])) {
        $game = $_SESSION['game'];
        if(isset($_GET['guess'])) {
            $guess =  $_GET['guess'];
            $game->check($guess);
            $game = $_SESSION['game'];
            if ($game->try == 4) {
                $game->try--;
                $game->result = 'danger';
                $game->leader ='Wat jammer!';
                $game->message = 'Je hebt het getal niet geraden het getal was: <strong>'.$game->number.'<strong></strong>';
                $_SESSION['game'] = $game;
            }
        }
    } else {
        $game = new Game();
        $_SESSION['game'] = $game;
    }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8" />
    <meta name="author" content="Jim de Vries"/>
    <meta name="description" content="HogerLager"/>
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
            <p>Negeer het posts gedeelte even, was om wat uit te proberen</p>
        </div>
        <?php if (isset($game->result)) {?>
            <div class="alert alert-<?php echo $game->result?>" role="alert">
                <strong>
                    <?php echo $game->leader ?>
                </strong>
                <?php echo $game->message ?>
            </div>
        <?php }?>
        <?php if (isset($msg->type)) {?>
            <div class="alert alert-<?php echo $msg->type?>" role="alert">
                <strong>
                    <?php echo $msg->leader ?>
                </strong>
                <?php echo $msg->body ?>
            </div>
        <?php }?>
        <div class="row justify-content-center">
            <?php if($game->result == 'success') { ?>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-block">
                        <h4 class="card-title">Score opslaan</h4>
                        <form method="post" action="#">
                            <div class="form-group">
                                <label for="name">Naam: </label>
                                <input class="form-control" type="text" name="name" id="name" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success">Score opslaan</button>
                            </div>
                        </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
            <?php if($game->result == 'success' or $game->result == 'danger') { ?>
                <div class="<?php if ($game->result == 'danger') {?> md-offset-4 <?php } ?>col-md-4">
                    <div class="card">
                        <div class="card-block">
                            <h3 class="card-title">Wil je opnieuw spelen?</h3>
                            <form method="get" action="#">
                                <input type="hidden" name="reset" value="1">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block">Nieuw Spel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
        <?php if($game->result != 'success' and $game->result != 'danger') { ?>
            <div class="col-md-6 offset-md-3">
                <strong>Poging: <?php echo $game->try ?></strong>
                <form  method="get" action="#">
                    <div class="form-group">
                        <label for="number">Je gok: </label>
                        <input type="number" class="form-control" name="guess" id="guess" min="1" max="10" required>
                        <small id="fileHelp" class="form-text text-muted">Voer een getal in tussen 1 en 10</small>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-block" <?php if($game->result == 'success' or $game->result == 'danger' or $game->try == 4) { ?> disabled<?php } ?> >Raden</button>
                    </div>
                </form>
            </div>
            <?php } ?>
        </div>
    <script src="https://code.jquery.com/jquery-3.1.1.slim.min.js" integrity="sha384-A7FZj7v+d/sdmMqp/nOQwliLvUsJfDHW+k9Omg/a/EheAdgtzNs3hpfag6Ed950n" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/tether/1.4.0/js/tether.min.js" integrity="sha384-DztdAPBWPRXSA/3eYEEUWrWCy7G5KFbe8fFjk5JAIxUYHKkDx6Qin1DkWx51bBrb" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" integrity="sha384-vBWWzlZJ8ea9aCX4pEW3rVHjgjt7zpkNpZk+02D9phzyeVkE+jo0ieGizqPLForn" crossorigin="anonymous"></script>
</body>
</html>
