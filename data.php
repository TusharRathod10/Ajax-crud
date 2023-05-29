<?php
$con = mysqli_connect('localhost', 'root', '', 'ajax') or die("Connection failed");

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$country = $_POST['country'];
$response = [];
if (empty($name)) {
    $response['name_err'] = "Name is required.";
    $response['status'] = 400;
}

if (empty($email)) {
    $response['email_err'] = "Email is required.";
    $response['status'] = 400;
}

if (empty($password)) {
    $response['password_err'] = "Password is required.";
    $response['status'] = 400;
}

if (empty($cpassword)) {
    $response['cpassword_err'] = "Confirm Password is required.";
    $response['status'] = 400;
} else if ($password != $cpassword) {
    $response['match_err'] = "Password Not Matched.";
    $response['status'] = 400;
}

if (empty($country)) {
    $response['country_err'] = "Please select country.";
    $response['status'] = 400;
}

if (isset($_POST['hobby'])) {
    $hobby = implode(',', $_POST['hobby']);
} else {
    $response['hobby_err'] = "Please select hobby.";
    $response['status'] = 400;
}

if (isset($_POST['gender'])) {
    $gender = $_POST['gender'];
} else {
    $response['gender_err'] = "Please select gender.";
    $response['status'] = 400;
}

if (empty($_FILES['images']['name'][0])) {
    $response['multiple_image_err'] = "Multiple image is required.";
    $response['status'] = 400;
}

if (empty($_FILES['image']['name'])) {
    $response['image_err'] = "Image is required.";
    $response['status'] = 400;
}

if (empty($response)) {
    $user = "SELECT email FROM crud WHERE `email`='$email'";
    $user_exe = mysqli_query($con, $user);
    $user_count = mysqli_num_rows($user_exe);

    if ($user_count > 0) {
        $response['repeat'] = "Email Already Exists !";
        $response['status'] = 400;
    } else {
        $explode = explode('.', $_FILES['image']['name']);
        $extension = end($explode);
        $image = time() . '.' . $extension;
        $tmp_name = $_FILES['image']['tmp_name'];
        $folder = "image/" . $image;
        if (move_uploaded_file($tmp_name, $folder)) {
            $images = $_FILES['images'];
            if (count($_FILES['images']['name']) >= 2) {
                $multiple_image = array();
                for ($i = 0; $i < count($images['name']); $i++) {
                    $rand = rand(100000000, 999999999);
                    $explode = explode('.', $images['name'][$i]);
                    $extension = end($explode);
                    $multiple_image[] = $rand . '.' . $extension;
                    move_uploaded_file($images['tmp_name'][$i], "images/" . $multiple_image[$i]);
                }
                $images = implode(',', $multiple_image);
                if (!empty($images)) {
                    $password = md5($password);
                    $insert = "INSERT INTO crud (`name`,`email`,`password`,`hobby`,`gender`,`country`,`image`,`images`) VALUES ('$name','$email','$password','$hobby','$gender','$country','$image','$images')";
                    $insert_exe = mysqli_query($con, $insert);
                    $response['success'] = "Data inserted successfully.";
                    $response['status'] = 200;
                }
            } else {
                $response['i_error'] = "Please select at least 2 images.";
                $response['status'] = 400;
            }
        } else {
            $response['error'] = "Something went wrong.";
            $response['status'] = 400;
        }
    }
} else {
    $response['error'] = "Something went wrong.";
    $response['status'] = 400;
}


echo json_encode($response);
?>