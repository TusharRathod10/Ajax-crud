<?php
$con = mysqli_connect('localhost', 'root', '', 'ajax') or die("Connection failed");
$res = array();

if (isset($_POST) && !empty($_POST)) {
    unset($_POST['password']);
    unset($_POST['cpassword']);
      $id = $_POST['id'];
    $fetch_user = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM crud WHERE `id`='$id'"));
    $hobby = explode(',', $fetch_user['hobby']);

    $name = ($_POST['name']) ? $_POST['name'] : $fetch_user['name'];
    $gender = ($_POST['gender']) ? $_POST['gender'] : $fetch_user['gender'];
    $email = ($_POST['email']) ? $_POST['email'] : $fetch_user['email'];
    $hobby = $_POST['hobby'] ? $_POST['hobby'] : $hobby;
    $country = $_POST['country'] ? $_POST['country'] : $fetch_user['country'];


    if (!empty($_FILES['image']['name'])) {
        if (!file_exists('image/')) {
            mkdir('image/', 0777, true);
        }
        @unlink('image/' . $fetch_user['image']);
        if ($_FILES['image']['size'] > 2000000) {
            $res['profile_size_err'] = "Profile size must be less then 2MB.";
            $res['status'] = 403;
        } else {
            $ext = pathinfo($_FILES['image']['name'], 4);
            if (strtolower($ext)) {
                $profile = time() . rand(000000, 999999) . '.' . $ext;
                $profile_tmp_name = $_FILES['image']['tmp_name'];
                $profile_upload = move_uploaded_file($profile_tmp_name, 'image/' . $profile);
            } else {
                $res['profile_ext_err'] = "Allowed extension is png.";
                $res['status'] = 403;
            }
        }
    } else {
        $profile = $fetch_user['image'];
    }

    if (!empty($_FILES['images']['name'][0])) {
        $memories = $_FILES['images'];
        $memories_arr = array();
        if (!file_exists('images/')) {
            mkdir('images/', 0777, true);
        }
        $old_memories_pic = !empty($fetch_user['images']) ? explode(',', $fetch_user['images']) : '';
        if (!empty($old_memories_pic)) {
            foreach ($old_memories_pic as $pic) {
                if (file_exists('images/' . $pic)) {
                    unlink('images/' . $pic);
                }
            }
        }
        for ($i = 0; $i < count($memories['name']); $i++) {
            $explode = explode('.', $memories['name'][$i]);
            $extension = end($explode);
            $memories_arr[] = time() . rand(100000000, 999999999) . '.' . $extension;
            move_uploaded_file($memories['tmp_name'][$i], 'images/' . $memories_arr[$i]);
        }
        $memories = implode(',', $memories_arr);
    } else {
        $memories = $fetch_user['images'];
    }
    $hobby = implode(" , ", $hobby);

    $update = "UPDATE crud SET `name`='$name', `gender`='$gender',`hobby`='$hobby',`country`='$country', `image`='$profile',`images`='$memories' WHERE `id`='$id'";
    $update_exe = mysqli_query($con, $update);
    if ($update_exe) {
        $res['status'] = 200;
        $res['success'] = "Data updated successfully.";
    } else {
        $res['status'] = 403;
        $res['error'] = "Somthing went wrong.";
    }

    echo json_encode($res);
}