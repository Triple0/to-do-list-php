<?php
session_start();

if (isset($_POST['reset'])) {
    session_unset();
}

if (!isset($_SESSION['new_task'])) {
    $_SESSION['new_task'] = array();
    $_SESSION['finished_task'] = array();
}

$_SESSION['new_task'] = array_values($_SESSION['new_task']);
$_SESSION['finished_task'] = array_values($_SESSION['finished_task']);
$clicked='initial value';

if (isset($_POST['submit']) && !empty($_POST['new_task'])) {
    array_push($_SESSION['new_task'], $_POST['new_task']);
}

foreach ( $_SESSION['new_task'] as $new_task ) {
    if ( isset( $_POST[$new_task] ) ) {
      array_push($_SESSION['finished_task'], $new_task);
      $position=array_search($new_task, $_SESSION['new_task'] );
      array_splice($_SESSION['new_task'],$position,1);
    }
  }


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $title; ?></title>
</head>

<body>
    <?php include './includes/navigation.php'; ?>
    <form action="./to-do.php" method="POST">
        <label for="new_task">
            <input type="text" id="new_task" name="new_task">
        </label>
        <input type="submit" id="submit" name="submit" value="Add To List">
        <input type="submit" id="reset" name="reset" value="Reset">


        <h2>Active To-Dos</h2>
        <?php if (!empty($_SESSION['new_task'])) :
        ?>
            <ul>
                <?php foreach ($_SESSION['new_task'] as $new_task) :
                ?>
                    <li>
                        <input type="checkbox" onChange='this.form.submit()' name="<?php echo $new_task; ?>" id="<?php echo $new_task; ?>" value="checked">
                        <?php echo $new_task; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
    </form>
    <?php endif; ?>
    <h2>Completed To-Dos</h2>
    <?php if (!empty($_SESSION['finished_task'])) :
?>
        <ul>
            <?php foreach ($_SESSION['finished_task'] as $finished_task) :
            ?>
                <li>
                    <?php echo $finished_task; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>


<h2>Debugging</h2>

<pre>
    <strong>$_POST contents:</strong>
    <?php var_dump($_POST); ?>
  </pre>
<pre>
    <strong>$_SESSION contents:</strong>
    <?php var_dump($_SESSION); ?>
  </pre>

</body>

</html>