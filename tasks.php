<?php
include_once "config.php";
$connection = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, );
if ( !$connection ) {
    throw new Exception( "Cannot connect to database" );
} else {
    $action = isset( $_POST['action'] ) ? $_POST['action'] : '';
    if ( !$action ) {
        header( 'Location: index.php' );
        die();
    } else {
        if ( 'add' == $action ) {
            // Insert Record
            $task = $_POST['task'];
            $date = $_POST['date'];

            if ( $task && $date ) {
                $query = "INSERT INTO tasks (task,date) VALUES('{$task}','{$date}')";
                mysqli_query( $connection, $query );
                header( 'Location: index.php?added=true' );
            }
        }else if( 'complete' == $action ){
            $taskid = $_POST['taskid'];
            if( $taskid ){
                $query = "UPDATE tasks SET complete=1 WHERE id = {$taskid} LIMIT 1";
                mysqli_query( $connection, $query );
            }
            header( 'Location: index.php' );
        }else if( 'incomplete' == $action ){
            $taskid = $_POST['taskid'];
            if( $taskid ){
                $query = "UPDATE tasks SET complete=0 WHERE id = {$taskid} LIMIT 1";
                mysqli_query( $connection, $query );
            }
            header( 'Location: index.php' );
        }
    }
}
mysqli_close($connection);