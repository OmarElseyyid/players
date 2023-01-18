<?php

require_once 'vendor/autoload.php';
require_once 'src/db.php';
require_once 'src/WaitingList.php';

$waitingList = new WaitingList($pdo);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Players Task</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <!-- alertify css-->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/css/alertify.min.css" />
    <!-- alertify js -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
    <script>       
        alertify.set('notifier','position', 'top-right');        
    </script>
</head>
<body>
    <!-- alertify Connected to the database successfully! if connected is true -->
    <?php if ($connected) : ?>
        <script>
            alertify.notify('Connected to the database successfully!', 'success', 5);            
        </script>
    <?php else: ?>
        <script>
            alertify.notify('Could not connect to the database!', 'error', 5);
        </script>
    <?php endif; ?>

    <div class="container mt-5">
        <h1>Waiting List</h1>
        <form action="index.php" method="post">
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter name">
            </div>
            <button type="submit" class="btn btn-primary">Add</button>
        </form>
        <table class="table mt-5">
            <thead>
                <tr>
                    <th scope="col">Name</th>
                    <th scope="col">Group</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($waitingList->getPlayers() as $player) : ?>
                    <tr>
                        <td><?php echo $player['name']; ?></td>
                        <td><?php echo $player['group_number']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>