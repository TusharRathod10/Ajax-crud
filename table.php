<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://getbootstrap.com/docs/5.3/assets/css/docs.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css"
        integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Bootstrap Example</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="p-3 m-0 border-0 bd-example">
    <p id='success'></p>
    <form id="profile_data" method="post" style="display: none;">
        <input type="text" name="id" id="id">
        <div class="my-2">
            <label for="name">Name </label>
            <input type="text" name="name" placeholder="Enter name" id="name" class="form-control">
        </div>
        <div class="my-2">
            <label for="email">Email </label>
            <input type="text" name="email" placeholder="Enter name" id="email" class="form-control">
        </div>
        <div class="my-2 d-flex align-items-center">
            <input type="radio" name="gender" value="male">
            <label for="" class="ms-2">Male </label>
        </div>
        <div class="my-2 d-flex align-items-center">
            <input type="radio" name="gender" value="female">
            <label for="" class="ms-2">Female </label>
        </div>
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

        <label for="country" class="my-2" style='font-weight :600;'>Country : </label><br>
        <select class="form-select" name='country' style='width:25%'>
            <option value="0" hidden selected>Select Country</option>
            <option value="india">India</option>
            <option value="usa">Usa</option>
            <option value="canada">Canada</option>
        </select><br>

        <div class="mb-3">
            <label for="image" class="form-label">Choose Profile : </label>
            <input class="form-control" type="file" name="image" style='width:25%'>
        </div>

        <div class="mb-3">
            <label for="images" class="form-label">Choose Images : </label>
            <input class="form-control" type="file" name="images[]" multiple style='width:25%'>
        </div>
        <div>
            <button class="btn btn-primary" type="button" id="submitBtn" onclick="updateUser()">Update</button>
        </div>
    </form>

    <table class="table table-light table-striped">

        <thead class="table-dark">
            <th>Id</th>
            <th>Name</th>
            <th>Email</th>
            <th>Password</th>
            <th>Gender</th>
            <th>Hobby</th>
            <th>Country</th>
            <th>Image</th>
            <th>Images</th>
            <th>Edit</th>
            <th>Delete</th>
        </thead>
        <tbody id="table_data">

        </tbody>

    </table>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script>
        $(document).ready(function () {
            fetchdata();
        });

        function fetchdata() {
            $.ajax({
                url: 'fetch-data.php',
                type: 'post',
                success: function (response) {
                    $('#table_data').html(response);
                }
            });
        }

        function getdata(id) {
            $.ajax({
                url: 'user_data.php',
                type: 'POST',
                data: {
                    id: id
                },
                success: function (response) {
                    let x = JSON.parse(response);
                    $('input[name="id"]').val(x.id)
                    $('input[name="name"]').val(x.name)
                    $('input[name="email"]').val(x.email)
                    $('select[name="country"]').val(x.country)
                    $('input[name="gender"][value=' + x.gender + ']').prop('checked', true)
                    var h = (x.hobby).split(',');
                    for (let index = 0; index < h.length; index++) {
                        $('input[name="hobby[]"][value=' + h[index] + ']').prop('checked', true)
                    }
                    $('table').hide();
                    $('#profile_data').show();
                }
            });
        }

        function delete_user(id) {
            // const swalWithBootstrapButtons = Swal.mixin({
            //     customClass: {
            //         confirmButton: 'btn btn-success',
            //         cancelButton: 'btn btn-danger'
            //     },
            //     buttonsStyling: false
            // })

            // swalWithBootstrapButtons.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonText: 'Yes, Delete it!',
            //     cancelButtonText: 'No, cancel!',
            //     reverseButtons: true
            // }).then((result) => {
            //     if (result.isConfirmed) {
            $.ajax({
                url: 'fetch-data.php?delete_user=' + btoa(id),
                type: 'POST',
                success: function (response) {
                    fetchdata();
                    // let res = JSON.parse(response);
                    // if (res.key == "delete_user") {
                    // swalWithBootstrapButtons.fire(
                    //     'Data updated successfully!',
                    //     res.key_message,
                    //     'success'
                    // )

                    // }
                    var x = JSON.parse(response);
                    if (x.status == 200) {
                        $('#success').text(x.success);
                    }
                }
            });
            // } else if (
            //     result.dismiss === Swal.DismissReason.cancel
            // ) {
            //     swalWithBootstrapButtons.fire(
            //         'Cancelled',
            //         '',
            //         'error'
            //     )
            // }
            //     })
            // }
        }
        function updateUser() {
            // const swalWithBootstrapButtons = Swal.mixin({
            //     customClass: {
            //         confirmButton: 'btn btn-success',
            //         cancelButton: 'btn btn-danger'
            //     },
            //     buttonsStyling: false
            // })

            // swalWithBootstrapButtons.fire({
            //     title: 'Are you sure?',
            //     text: "You won't be able to revert this!",
            //     icon: 'warning',
            //     showCancelButton: true,
            //     confirmButtonText: 'Yes, Do it!',
            //     cancelButtonText: 'No, cancel!',
            //     reverseButtons: true
            // }).then((result) => {
            //     if (result.isConfirmed) {
            $.ajax({
                url: "update.php",
                type: "POST",
                data: new FormData(document.getElementById("profile_data")),
                processData: false,
                contentType: false,
                success: function (res) {
                    // alert('hello');
                    let a = JSON.parse(res);
                    if (a.status == 200) {
                        $('#success').text(a.success);
                    }
                    fetchdata();
                    $('table').show();
                    $('#profile_data').hide();
                }
            })
            // } else if (
            //     result.dismiss === Swal.DismissReason.cancel
            // ) {
            //     swalWithBootstrapButtons.fire(
            //         'Cancelled',
            //         '',
            //         'error'
            //     )
            // }
        }
        //     )
        // }
    </script>
</body>

</html>