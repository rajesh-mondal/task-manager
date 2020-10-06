<?php
include_once "config.php";
$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, );
if ( !$connection ) {
    throw new Exception( "Cannot connect to database" );
}
$query = "SELECT * FROM tasks WHERE complete = 0 ORDER BY date";
$result = mysqli_query( $connection, $query );

$completeTasksQuery = "SELECT * FROM tasks WHERE complete = 1 ORDER BY date";
$resultCompleteTasks = mysqli_query( $connection, $completeTasksQuery );

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Todo/Tasks</title>
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Roboto:300,300italic,700,700italic">
    <link rel="stylesheet" href="//cdn.rawgit.com/necolas/normalize.css/master/normalize.css">
    <link rel="stylesheet" href="//cdn.rawgit.com/milligram/milligram/master/dist/milligram.min.css">
    <style>
        body {
            margin-top: 30px;
        }
        #main{
            padding: 0px 150px 0px 150px;
        }
        #action{
            width: 150px;
        }
    </style>
</head>
<body>
<div class="container" id="main">
    <h2>Tasks Manager</h2>
    <p>This is a sample project for managing our daily tasks. We are going to use HTML, CSS, PHP, MySQL, jQuery for this project</p>
    <?php 
    if( mysqli_num_rows( $resultCompleteTasks ) > 0 ) {
        ?>
        <h4>Complete Tasks</h4>
        <table>
            <thead>
            <tr>
                <th></th>
                <th>Id</th>
                <th>Task</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody>
            <?php
            while( $cdata = mysqli_fetch_assoc( $resultCompleteTasks ) ) {
                $timestamp = strtotime( $cdata['date'] );
                $cdate = date( "jS M, Y", $timestamp );
                ?>
                <tr>
                    <td><input class="label-inline" type="checkbox" value="<?php echo $cdata['id']; ?>"></td>
                    <td><?php echo $cdata['id']; ?></td>
                    <td><?php echo $cdata['task']; ?></td>
                    <td><?php echo $cdate; ?></td>
                    <td><a href="#">Delete</a> </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <p>...</p>
        <?php
    }
    ?>
        
    <?php 
    if( mysqli_num_rows( $result ) ==0 ){
        ?>
        <p>No Task Found</p>
        <?php
    }else{
    ?>
    <h4>Upcomming Tasks</h4>
    <table>
        <thead>
        <tr>
            <th></th>
            <th>Id</th>
            <th>Task</th>
            <th>Date</th>
            <th>Action</th>
        </tr>
        </thead>
        <tbody>
        <?php
        while($data = mysqli_fetch_assoc( $result ) ) {
            $timestamp = strtotime( $data['date'] );
            $date = date( "jS M, Y", $timestamp );
            ?>
            <tr>
                <td><input class="label-inline" type="checkbox" value="<?php echo $data['id']; ?>"></td>
                <td><?php echo $data['id']; ?></td>
                <td><?php echo $data['task']; ?></td>
                <td><?php echo $date; ?></td>
                <td><a href="#">Delete</a> | <a href="#">Edit</a> | <a href="#">Complete</a></td>
            </tr>
            <?php
        }
        mysqli_close( $connection );
        ?>
        </tbody>
    </table>
    <select id="action">
        <option value="0">With Selected</option>
        <option value="delete">Delete</option>
        <option value="complete">Mark As Complete</option>
    </select>
    <input class="button-primary" id="bulksubmit" type="submit" value="Submit">
    <?php
    }
    ?>
    <p>...</p>
    <h4>Add Tasks</h4>
    <form method="post" action="tasks.php">
        <fieldset>
            <?php
                $added = $_GET['added'] ?? '';
                if ( $added ) {
                    echo '<p>Task Successfully Added</p>';
                }
            ?>
            <label for="task">Task</label>
            <input type="text" placeholder="Task Details" id="task" name="task">
            <label for="date">Date</label>
            <input type="text" placeholder="Task Date" id="date" name="date">

            <input class="button-primary" type="submit" value="Add Task">
            <input type="hidden" name="action" value="add">
        </fieldset>
    </form>
</div>
</body>
</html>