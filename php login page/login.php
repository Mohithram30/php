<?php 
session_start();
include "db_conn.php";

if (isset($_POST['uname']) && isset($_POST['password'])) {

    function validate($data): string {
        $data = trim(string: $data);
        $data = stripslashes(string: $data);
        $data = htmlspecialchars(string: $data);
        return $data;
    }

    $uname = validate(data: $_POST['uname']);
    $pass = validate(data: $_POST['password']);

    if (empty($uname)) {
        header(header: "Location: index.php?error=User Name is required");
        exit();
    } 
    else if (empty($pass)) {
        header(header: "Location: index.php?error=Password is required");
        exit();
    } else {
        $sql = "SELECT * FROM users WHERE user_name = ? AND password = ?";
        $stmt = mysqli_prepare(mysql: $conn, query: $sql);
        mysqli_stmt_bind_param(statement: $stmt, types: "ss", var: $uname, vars: $pass);
        mysqli_stmt_execute(statement: $stmt);
        $result = mysqli_stmt_get_result(statement: $stmt);

        if (mysqli_num_rows(result: $result) === 1) {
            $row = mysqli_fetch_assoc(result: $result);
            if ($row['user_name'] === $uname && $row['password'] === $pass) {
                $_SESSION['user_name'] = $row['user_name'];
                $_SESSION['name'] = $row['user_name'];
                $_SESSION['id'] = $row['id'];
                header(header: "Location: home.php");
                exit();
            } else {
                header(header: "Location: index.php?error=Incorrect username or password");
                exit();
            }
        } else {
            header(header: "Location: index.php?error=Incorrect username or password");
            exit();
        }
    }
} else {
    header(header: "Location: index.php");
    exit();
}
