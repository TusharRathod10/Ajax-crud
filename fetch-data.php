<?php
$con = mysqli_connect('localhost', 'root', '', 'ajax') or die('Connection failed');

$users = mysqli_query($con, "SELECT * FROM crud");

$res = [];

if (!empty($_GET['delete_user'])) {
    $id = base64_decode($_GET['delete_user']);
    $fetch_user = mysqli_fetch_assoc(mysqli_query($con, "SELECT * FROM crud WHERE `id`='$id'"));
    if (!empty($fetch_user['images']) && !empty($fetch_user['image'])) {
        if (!empty($fetch_user['image'])) {
            @unlink('image/' . $fetch_user['image']);
        }
        $old_pics = !empty($fetch_user['images']) ? explode(',', $fetch_user['images']) : '';
        if (!empty($old_pics)) {
            foreach ($old_pics as $pic) {
                if (file_exists('images/' . $pic)) {
                    unlink('images/' . $pic);
                }
            }
        }
        $delete_user = mysqli_query($con, "DELETE FROM crud WHERE `id`='$id'");
        if ($delete_user) {
            $res['success'] = "User deleted successfully";
            $res['status'] = 200;
            echo json_encode($res);
        }
    }
}

$table_row = '';
while ($data = mysqli_fetch_assoc($users)) {
    $memories = explode(',', $data['images']);
    $table_row .= '<tr><td>' . $data['id'] . '</td>
                    <td>' . $data['name'] . '</td>
                    <td>' . $data['email'] . '</td>
                    <td>' . $data['password'] . '</td>
                    <td>' . $data['gender'] . '</td>
                    <td>' . $data['hobby'] . '</td>
                    <td>' . $data['country'] . '</td>
                    <td><div style="width: 100px;height: 100px;"><img src="' . 'image/' . $data['image'] . '" style="max-width: 100%;max-height: 100%;"></div></td><td>';
    for ($i = 0; $i < count($memories); $i++) {
        $table_row .= '<div style="width: 75px;height: 75px; margin:10px 0px;"><img src="' . 'images/' . $memories[$i] . '" style="max-width: 100%;max-height: 100%; border: 1px solid black; padding: 5px;"></div>';
    }
    $table_row .= '</td><td><button class="btn btn-secondary" onclick="getdata(' . $data['id'] . ')"><i class="fa fa-edit"></i></button></td>';
    $table_row .= '</td><td><button class="btn btn-danger" onclick="delete_user(' . $data['id'] . ')"><i class="fa fa-trash"></i></button></td>';

    $table_row .= '</td></tr>';
}
echo '<pre>' . $table_row;

?>