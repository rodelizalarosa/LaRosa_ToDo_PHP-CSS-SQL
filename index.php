<?php

require_once 'vendor/autoload.php';

use Rodeliza\Dbmodel\Models\Task;

// Usage example
$todo = new Task();

// checks if the button is clicked and the form is submitted. If true, run the createUser() function from our User class
// Then pass in an array of data to the createUser class since createUser accepts an array of data
    if(isset($_POST['addtask'])) {
        $todo->createTask([
            'task' => $_POST['task'],
        ]);
    }
    
    if (isset($_GET["delete"])) {
        $id = $_GET["delete"];
        $todo->deleteTask($id); 
        header("Location: index.php");
    }

    if (isset($_GET["complete"])) {
        $id = $_GET["complete"];
        $task = $todo->getTask($id); 
        if ($task) {
            $todo->updateTask([
                'id' => $id,
                'task' => $task['task'], 
                'status' => 'completed'
            ]);
            header("Location: index.php");
        }
    }
    $result = $todo->getTasks(); 

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    
    <div class="container">
        <h1>To-do List</h1>
        <form action="index.php" method="POST">
            <input type="text" name="task" placeholder="Enter new task" id="">
            <button type="submit" name="addtask">Add Task</button>
        </form>
        <ul>
            <?php foreach ($result as $row): ?>
                <li>
                    <span class="<?php echo ($row["status"] == "completed" ? "task-text completed" : "task-text"); ?>">
                        <strong><?php echo $row["task"]; ?></strong>
                    </span>
                    <div class="actions">
                        <a href="index.php?complete=<?php echo $row['id']; ?>">Complete</a>
                        <a href="index.php?delete=<?php echo $row['id']; ?>" class="delete-link">Delete</a>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

</body>
</html>