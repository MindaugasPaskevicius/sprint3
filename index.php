<?php
session_start();
require_once 'database/database.php';
require_once 'app/selection.php';
require_once 'app/save.php';
require_once 'app/delete.php';
require_once 'app/search.php';
require_once 'app/edit.php';
require_once 'app/update.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Manager</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</head>

<body>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg navbar-light">
            <div class="collapse navbar-collapse">
                <div class="nav-button">
                    <span>
                        <li><a class="ms-5" href="?path=projects">Projects</a></li>
                        <li><a href="?path=employees">Employees</a></li>
                    </span>
                </div>
            </div>
            <div class="float-end align-middle">
                <h4 class="align-middle text-white">PROJECT MANAGER</h4>
            </div>
        </nav>
    </header>

    <?php
    if (isset($_SESSION['message'])) : ?>
        <div class="marginass alert alert-<?= $_SESSION['msg_type'] ?>">
            <?php
            echo $_SESSION['message'];
            unset($_SESSION['message']);
            ?>
        </div>
    <?php endif ?>

    <main>
        <div class="marginas container">
            <div class="row justify-content-left">
                <form action="<?php ($_SERVER['REQUEST_URI']); ?>" method="post">
                    <?php if (isset($_GET['path']) AND ($_GET['path'] == "employees" || $_GET['path'] == "")) : ?>
                        <div class="form-group">
                            <label for="name"><?php echo (($update == true) ? ("<strong>Edit Employee</strong>") : ("<strong>Add Employee</strong>")); ?></label>
                            <div class="form-group d-flex">
                                <input type="text" class="form-control" name="name" value="<?php echo ($update == true ? $first_en : ""); ?>" placeholder="Enter employee's name">
                                <?php
                                if ($update) {
                                    $query = "SELECT projects.id, projects.name FROM projects";
                                    $res = mysqli_query($conn, $query) or die(mysqli_connect_error($query));
                                    echo ("<select class='ml-5 custom-select' name='select_name'>");
                                    echo ("<option value=''selected disabled>Projects</option>");
                                    while ($row = mysqli_fetch_array($res)) {
                                        echo "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                    }
                                    echo ("</select>");
                                }
                                ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="form-group">
                            <label for="name"><?php echo (($update == true) ? ("<strong>Edit Project</strong>") : ("<strong>Add Project</strong>")); ?></label>
                            <input type="text" class="form-control" value="<?php echo ($update == true ? $first_en : ""); ?>" name="name" placeholder="Enter project's name">
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <?php if ($update == true) : ?>
                            <button class="btn btn-warning" type="submit" name="update">Update</button>
                        <?php else : ?>
                            <button class="btn btn-warning" type="submit" name="save">Save</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        <?php

        print('<div class="container mt-5"><table class="table"><thead><tr><th>ID</th><th>' . (isset($_GET['path']) && $_GET['path'] === 'projects' ?  "Project's Name" : "Employee's Name") . '</th><th>' . (isset($_GET['path']) && $_GET['path'] === 'projects' ?  "Employee's Name" : "Project's Name") . '</th><th>Action</th>');

        $stmt->execute();
        $stmt->store_result();
        $count = $stmt->num_rows;
        if ($count > 0) {
            while ($stmt->fetch()) {
                echo "<tr>
                    <td>" . $id . "</td>
                    <td>" . $first_en . "</td>
                    <td>" . $second_en . "</td>
                    <td>
                    <button class='btn-warning'><a class='table-button' style='text-decoration:none' href=\"?path=" . $table_name . "&delete=$id\">" . (isset($_GET['path']) && $_GET['path'] === 'projects' ?  "DELETE" : "DELETE") . "</a></button>
                    <button class='btn-warning'><a class='table-button' style='text-decoration:none' href=\"?path=" . $table_name . "&edit=$id\">" . (isset($_GET['path']) &&  $_GET['path'] === 'projects' ?  "EDIT" : "EDIT") . "</a></button>
                    </td>
                </tr>";
            }
            print('</table>');
            print('<br />');
            print('<br />');
        } else {
            echo ("<tr>
        <td>No data found</td></tr>");
            print('</table>');
        }
        ?>
    </main>
    <footer class="footer text-center pt-3 pb-3">
        <span class="text-white">Kaunas 2022</span>
    </footer>
</body>

</html>
<?php
$stmt->free_result();
$stmt->close();

mysqli_close($conn);
unset($_SESSION['msg_type']);
session_destroy();
?>

