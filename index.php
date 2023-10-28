<?php
// connection
$conn = mysqli_connect("localhost", "root", "", "crud");

if (!$conn) {
    die("Connection Failed" . mysqli_connect_error());
}
?>

<!DOCTYPE html>
<html lang="en">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

<!-- datatables css -->
<link rel="stylesheet" href="//cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<body>
    <!-- nav bar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="#">CRUD APP</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">About</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">Contact</a>
                </li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
            </form>
        </div>
    </nav>

    <?php
    // for deleting record
    if (isset($_GET['delete'])) {
        $sr_no = $_GET['delete'];
        $sql = "DELETE FROM `notes` WHERE `sr_no` = $sr_no;";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            echo "<div class='alert alert-success' role='alert'>
        <strong>Success!</strong> Note successfully deleted.
      </div>
      </div>";
        } else {
            echo "Error occurred: " . mysqli_error($conn);
        }
    }

    // for updating and inserting record
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
        if (isset($_POST['sr_noEdit'])) {
            // updating the record
            $title = $_POST['titleEdit'];
            $desc = $_POST['descEdit'];
            $sr_no = $_POST['sr_noEdit'];

            $sql = "UPDATE `notes` SET `title` = '$title', `description` = '$desc' WHERE `sr_no` = $sr_no;";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                echo "<div class='alert alert-success' role='alert'>
            <strong>Success!</strong> Note successfully updated.
          </div>
          </div>";
            } else {
                echo "Error occurred: " . mysqli_error($conn);
            }
        } else {
            // inserting the record
            $title = $_POST['title'];
            $desc = $_POST['desc'];

            $sql = "INSERT INTO `notes`(`title`, `description`) VALUES ('$title','$desc')";
            $result = mysqli_query($conn, $sql);

            if ($result) {
                $insert = true;
                echo "<div class='alert alert-success' role='alert'>
            <strong>Success!</strong> Note successfully entered.
          </div>
          </div>";
            } else {
                echo "Error occurred: " . mysqli_error($conn);
            }
        }
    }
    ?>

    <!-- Edit Modal -->
    <div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="EditModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="EditModalLabel">Edit this Note</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="/index.php" method="POST">
                    <div class="modal-body">
                        <input type="hidden" name="sr_noEdit" id="sr_noEdit">
                        <div class="form-group">
                            <label for="title">Note Title</label>
                            <input type="text" class="form-control" id="titleEdit" name="titleEdit" aria-describedby="title">
                        </div>
                        <div class="form-group">
                            <label for="desc">Note Description</label>
                            <textarea class="form-control" id="descEdit" name="descEdit" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- insertion form -->
    <div class="container my-4">
        <h2>Add a Note</h2>
        <form action="/index.php" method="POST">
            <div class="form-group">
                <label for="title">Note Title</label>
                <input type="text" class="form-control" id="title" name="title" aria-describedby="title">
            </div>
            <div class="form-group">
                <label for="desc">Note Description</label>
                <textarea class="form-control" id="desc" name="desc" rows="3"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Add Note</button>
        </form>
    </div>

    <div class="container">
        <table class="table" id="myTable">
            <thead class="thead-dark">
                <tr>
                    <th scope="col">Sr No</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col">Time Stamp</th>
                    <th scope="col">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php


                $sql = "select * from notes";
                $result = mysqli_query($conn, $sql);
                $sr_no = 0;
                while ($row = mysqli_fetch_assoc($result)) {
                    $sr_no += 1;
                    echo "
                    <tr>
                    <th scope='row'>" . $sr_no . "</th>
                    <td>" . $row['title'] . "</td>
                    <td>" . $row['description'] . "</td>
                    <td>" . $row['timestamp'] . "</td>
                    <td>" . '<button class="edit btn btn-primary" id=' . $row["sr_no"] . '>Edit</button> <button class="delete btn btn-primary" id=d' . $row["sr_no"] . '>Delete</button>' . "</td>
                    </tr>
                    ";
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Edit Modal Script -->
    <script>
        edits = document.getElementsByClassName('edit');
        Array.from(edits).forEach((element) => {
            element.addEventListener("click", (e) => {
                tr = e.target.parentNode.parentNode;
                title = tr.getElementsByTagName("td")[0].innerText;
                desc = tr.getElementsByTagName("td")[1].innerText;
                console.log(title, desc);
                titleEdit.value = title;
                descEdit.value = desc;
                sr_noEdit.value = e.target.id;

                $('#EditModal').modal('toggle');
            })
        })
    </script>

    <!-- Delete Script -->
    <script>
        deletes = document.getElementsByClassName('delete');
        Array.from(deletes).forEach((element) => {
            element.addEventListener("click", (e) => {
                sr_no = e.target.id.substr(1, );

                if (confirm("Are you sure you want to delete the note!")) {
                    console.log('yes');
                    window.location = `index.php?delete=${sr_no}`;
                } else {
                    console.log('no');
                }
            })
        })
    </script>

    <!-- jQuery first, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- datatables js -->
    <script src="//cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    <!-- datatables -->
    <script>
        let table = new DataTable('#myTable');
    </script>
</body>

</html>