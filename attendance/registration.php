<!DOCTYPE html>
<html>
<head>
    <title>Registration Form Using AJAX and jQuery in PHP</title>

    <!-- jQuery -->
    <script src="jquery/jquery.js"></script>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">

    <!-- Fontawesome -->
    <link rel="stylesheet" href="fontawesome/css/all.css">

    <!-- Bootstrap JS -->
    <script src="js/bootstrap.js"></script>

    <!-- Custom CSS -->
    <link rel="stylesheet" href="style/customstyle.css">

    <!-- Custom Script -->
    <script>
        $(document).ready(function () {
            $("#submitBtn").click(function (e) {
                e.preventDefault();

                var form = $('#registerForm')[0];
                var formData = new FormData(form);

                $.ajax({
                    url: 'registration-val.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        $("#result").html(data);

                        if (data.toLowerCase().includes("registration completed successfully")) {
                            $("#popupMessage").html(data);
                            $("#successPopup").fadeIn();

                            setTimeout(function () {
                                $("#successPopup").fadeOut();
                            }, 2000);
                        }
                    }
                });
            });

            $("#closePopup").click(function () {
                $("#successPopup").fadeOut();
            });
        });
    </script>

    <style>
        #successPopup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border: 2px solid #28a745;
            border-radius: 10px;
            padding: 20px 30px;
            z-index: 9999;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.3);
            text-align: center;
        }

        #popupMessage {
            color: #28a745;
            font-weight: bold;
        }

        #closePopup {
            background: none;
            border: none;
            color: red;
            font-size: 24px;
            cursor: pointer;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="bg">
    <div class="container pt-4">
        <h3 class="text-white text-center"><i class="fas fa-user-edit"></i> Register Here </h3>
        <div class="wrapper">
            <form id="registerForm" enctype="multipart/form-data">
                <div class="row row-layout mt-4">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-10 m-auto">
                        <label for="firstName">First Name</label>
                        <input type="text" id="firstName" name="firstname" class="form-control" placeholder="First Name" required>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-10 m-auto">
                        <label for="lastName">Last Name</label>
                        <input type="text" id="lastName" name="lastname" class="form-control" placeholder="Last Name">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-10 col-10 m-auto">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" class="form-control" placeholder="Email">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-10 m-auto">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="pass" class="form-control" placeholder="Password">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-10 m-auto">
                        <label for="confirmPassword">Confirm Password</label>
                        <input type="password" id="confirmPassword" name="cpass" class="form-control" placeholder="Password">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-10 m-auto">
                        <label for="mobile">Mobile No.</label>
                        <input type="text" id="mobile" name="mobile" class="form-control" placeholder="Mobile No.">
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-10 m-auto">
                        <label for="city">City</label>
                        <input type="text" id="city" name="city" class="form-control" placeholder="City">
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-10 col-10 m-auto">
                        <label for="address">Address</label>
                        <textarea id="address" name="add" class="form-control" rows="3" placeholder="Address"></textarea>
                    </div>
                </div>

                <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-10 col-10 m-auto">
                        <label for="doj">Date of Joining</label>
                        <input type="date" id="doj" name="doj" class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-5 m-auto">
                        <label for="shiftStart">Shift Start</label>
                        <input type="time" id="shiftStart" name="shiftStart" class="form-control">
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3 col-sm-5 col-5 m-auto">
                        <label for="shiftEnd">Shift End</label>
                        <input type="time" id="shiftEnd" name="shiftEnd" class="form-control">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-10 col-10 m-auto">
                        <label for="profilePic">Upload Profile Picture</label>
                        <input type="file" id="profilePic" name="profilePic" class="form-control" accept="image/*">
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-10 m-auto">
                        <button id="submitBtn" class="btn btn-success btn-block">Register</button>
                    </div>
                </div>
            </form>

            <div class="row mt-3">
                <div class="col-xl-6 col-lg-6 col-md-6 col-8 m-auto">
                    <span class="registered">Already Registered? <a href="login.php" class="text-warning text-center"> Login here</a></span>
                </div>
            </div>

            <div class="row">
                <div id="result" class="col-xl-12 col-lg-12 col-md-12 col-10 m-auto"></div>
            </div>
        </div>
    </div>
</div>

<!-- Popup -->
<div id="successPopup">
    <span id="popupMessage">Registration completed successfully.</span>
    <div>
        <button id="closePopup">&times;</button>
    </div>
</div>

</body>
</html>
