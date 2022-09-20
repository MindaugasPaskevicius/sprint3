<?php
session_start();
include 'database/database.php';
include 'app/selection.php';
include 'app/add.php';
include 'app/delete.php';
include 'app/search.php';
include 'app/edit.php';
include 'app/update.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Project Manager</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>

<body>
    <header>
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
    <main>
        <div class="container mt-5">
            <div class="row justify-content-left">
                <form action="<?php ($_SERVER['REQUEST_URI']); ?>" method="post">
                    <?php if ($_GET['path'] == "employees" || $_GET['path'] == "") : ?>
                        <div class="form-group">
                            <label for="name"><?php print(($update == true) ? ("<strong>Edit Employee</strong>") : ("<strong>Add Employee</strong>")); ?></label>
                            <div class="form-group d-flex">
                                <input type="text" class="form-control" name="name" value="<?php print($update == true ? $first_en : ""); ?>" placeholder="Enter employee's name">
                                <?php
                                if ($update) {
                                    $query = "SELECT projects.id, projects.name FROM projects";
                                    $res = mysqli_query($conn, $query) or die(mysqli_connect_error($query));
                                    print("<select class='ml-5 custom-select' name='select_name'>");
                                    print("<option value=''selected disabled>Projects</option>");
                                    while ($row = mysqli_fetch_array($res)) {
                                        print "<option value=" . $row['id'] . ">" . $row['name'] . "</option>";
                                    }
                                    print("</select>");
                                }
                                ?>
                            </div>
                        </div>
                    <?php else : ?>
                        <div class="form-group">
                            <label for="name"><?php print(($update == true) ? ("<strong>Edit Project</strong>") : ("<strong>Add Project</strong>")); ?></label>
                            <input type="text" class="form-control" value="<?php print($update == true ? $first_en : ""); ?>" name="name" placeholder="Enter project's name">
                        </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <?php if ($update == true) : ?>
                            <button class="btn btn-light" type="submit" name="update">Update</button>
                        <?php else : ?>
                            <button class="btn btn-light" type="submit" name="save">Add</button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>
        <?php

        print('<div class="container mt-5"><table class="table"><thead><tr><th>ID</th><th>' . ($_GET['path'] === 'projects' ?  "Project's Name" : "Employee's Name") . '</th><th>' . ($_GET['path'] === 'projects' ?  "Employee's Name" : "Project's Name") . '</th><th>Action</th>');

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
                        <button class='btn-light'><a class='table-button' style='text-decoration:none' href=\"?path=" . $table_name . "&delete=$id\">" . ($_GET['path'] === 'projects' ?  "DELETE" : "DELETE") . "</a></button>
                        <button class='btn-light'><a class='table-button' style='text-decoration:none' href=\"?path=" . $table_name . "&edit=$id\">" . ($_GET['path'] === 'projects' ?  "EDIT" : "EDIT") . "</a></button>
                    </td>
                </tr>";
            }
            print('</table>');
            print('<br />');
            print('<br />');
        } else {
            print("<tr>
        <td>No data found</td></tr>");
            print('</table>');
        }
        ?>
    </main>

    <footer class="footer mt-auto py-3 text-center">
        <div class="container">
            <span class="text-white">Kaunas 2022</span>
        </div>
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