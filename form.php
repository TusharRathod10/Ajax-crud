<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <title>Bootstrap Example</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="p-3 m-0 border-0 bd-example">

    <h1>Form</h1><br>
    <p id="success" style="color:green; font-weight: bold;"></p>
    <p id="error" style="color:red; font-weight: bold;"></p>
    <form action="" method="post" id="form" enctype="multipart/form-data">

        <label for="name" class="my-2" style='font-weight :600;'>Name : </label>
        <input type="text" name="name" id="" class='form-control' style='width:25%'><br>
        <p id="name_err" style="color:red; font-weight: bold;"></p>


        <label for="email" class="my-2" style='font-weight :600;'>Email : </label>
        <input type="email" name="email" id="" class='form-control' style='width:25%'><br>
        <p id="email_err" style="color:red; font-weight: bold;"></p>
        <p id="repeat" style="color:red; font-weight: bold;"></p>


        <label for="password" class="my-2" style='font-weight :600;'>Password : </label>
        <input type="password" name="password" id="" class='form-control' style='width:25%'><br>
        <p id="password_err" style="color:red; font-weight: bold;"></p>


        <label for="cpassword" class="my-2" style='font-weight :600;'>Confirm Password : </label>
        <input type="password" name="cpassword" id="" class='form-control' style='width:25%'><br>
        <p id="cpassword_err" style="color:red; font-weight: bold;"></p>


        <label for="gender" class="my-2" style='font-weight :600;'>Gender : </label><br>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="male">Male
        </div>
        <div class="form-check">
            <input class="form-check-input" type="radio" name="gender" value="female">Female
        </div><br>
        <p id="gender_err" style="color:red; font-weight: bold;"></p>


        <label for="hobby" class="my-2" style='font-weight :600;'>Hobby : </label><br>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="hobby[]" value="cricket">Cricket
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="hobby[]" value="football">Football
        </div>
        <div class="form-check">
            <input class="form-check-input" type="checkbox" name="hobby[]" value="travelling">Travelling
        </div><br>
        <p id="hobby_err" style="color:red; font-weight: bold;"></p>


        <label for="country" class="my-2" style='font-weight :600;'>Country : </label><br>
        <select class="form-select" name='country' style='width:25%'>
            <option value="0" hidden selected>Select Country</option>
            <option value="india">India</option>
            <option value="usa">Usa</option>
            <option value="canada">Canada</option>
        </select><br>
        <p id="country_err" style="color:red; font-weight: bold;"></p>


        <div class="mb-3">
            <label for="image" class="form-label">Choose Profile : </label>
            <input class="form-control" type="file" name="image" style='width:25%'>
        </div>
        <p id="image_err" style="color:red; font-weight: bold;"></p>


        <div class="mb-3">
            <label for="images" class="form-label">Choose Images : </label>
            <input class="form-control" type="file" name="images[]" multiple style='width:25%'>
        </div>
        <p id="multiple_image_err" style="color:red; font-weight: bold;"></p>
        <p id="i_error" style="color:red; font-weight: bold;"></p>
        <p id="match_err" style="color:red; font-weight: bold;"></p>


        <button type="submit" name='submit' value="submit" id="submit" class='btn btn-primary'>Submit</button>

    </form>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.0.2/js/toastr.min.js"></script>
    <script>
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }
        $('#form').submit(function (e) {
            e.preventDefault();
            $.ajax({
                url: 'data.php',
                type: 'POST',
                data: new FormData(this),
                processData: false,
                contentType: false,
                success: function (response) {
                    $('#name_err').text("");
                    $('#email_err').text("");
                    $('#password_err').text("");
                    $('#cpassword_err').text("");
                    $('#hobby_err').text("");
                    $('#gender_err').text("");
                    $('#country_err').text("");
                    $('#multiple_image_err').text("");
                    $('#image_err').text("");
                    $('#repeat').text("");
                    $('#i_error').text("");
                    $('#match_err').text("");
                    $('#error').text("");
                    var x = JSON.parse(response);
                    if (x.status == 400) {
                        $('#name_err').text(x.name_err);
                        $('#email_err').text(x.email_err);
                        $('#password_err').text(x.password_err);
                        $('#cpassword_err').text(x.cpassword_err);
                        $('#hobby_err').text(x.hobby_err);
                        $('#gender_err').text(x.gender_err);
                        $('#country_err').text(x.country_err);
                        $('#multiple_image_err').text(x.multiple_image_err);
                        $('#image_err').text(x.image_err);
                        $('#repeat').text(x.repeat);
                        $('#i_error').text(x.i_error);
                        $('#match_err').text(x.match_err);
                        $('#error').text(x.error);
                    } else if (x.status == 200) {
                        $('#success').text(x.success);
                        $('#form')[0].reset();
                    }
                }
            })
        })
    </script>
</body>

</html>
