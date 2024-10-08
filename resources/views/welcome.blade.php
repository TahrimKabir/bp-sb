<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Special Branch | Admin Login</title>
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .header {
            background-color: #6c757d;
            color: #fff;
            padding: 20px;
        }
        .logo img {
            height: 60px;
        }
        .container {
            max-width: 500px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 20px;
        }
        .btn-login {
            padding-left: 2.5rem;
            padding-right: 2.5rem;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            background-color: #6c757d;
            color: #fff;
            padding: 10px 0;
            border-radius: 0 0 10px 10px;
        }
    </style>
</head>
<body>
<div class="header">
    <div class="container-fluid">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <a href="#" class="nav-link">
                    <div class="logo">
                        <img src="{{asset('images/logo.png')}}" alt="Logo">
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>
<div class="form-content d-flex justify-content-center align-items-center" style="height: 78vh" >

    <div class="container" >


            @if ($errors->any())

                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger mb-3 text-center text-decoration-none">
                        {{ $error }}
                        </div>
                    @endforeach

            @endif



        <form method="POST" action="{{ route('login') }}">
            @csrf
            <h2 id="loginHeading" class="text-center mb-3">Admin Login</h2>
            <div id="dynamicFields">
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" class="form-control" placeholder="Enter Password" name="password" required>
                </div>
            </div>
            <div class="form-group">
                <label for="loginType">Login Type</label>
                <select class="form-control" id="loginType" name="loginType">
                    <option value="admin" selected>Admin</option>
                    <option value="examiner">Examiner</option>
                    <option value="member">Member</option>
                </select>
            </div>

            <div class="text-center">
                <input type="submit" value="Login" class="btn btn-primary btn-login" name="admin_login">
            </div>
        </form>
    </div>
</div>
<div class="footer">
    <p>Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | Special Branch</p>
</div>



<script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
<script>
    $(document).ready(function() {
        // Initialize with admin fields
        var adminFieldsHtml = `
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" class="form-control" placeholder="Enter Password" name="password" required>
            </div>
        `;

        // Initialize with member fields
        var memberFieldsHtml = `
            <div class="form-group">
                <label for="bpid">BPID</label>
                <input type="text" class="form-control" id="bpid" name="bpid" placeholder="Enter BPID" required>
            </div>
            <div class="form-group">
                <label for="mobile">Mobile No.</label>
                <input type="text" class="form-control" id="mobile" name="mobile" placeholder="Enter mobile no." required>
            </div>
        `;

        // Handle login type change
        $('#loginType').change(function() {
            var loginType = $(this).val();
            var dynamicFields = $('#dynamicFields');
            var loginHeading = $('#loginHeading');

            if (loginType === 'admin') {
                dynamicFields.html(adminFieldsHtml);
                loginHeading.text('Admin Login');
            } else if (loginType === 'member') {
                dynamicFields.html(memberFieldsHtml);
                loginHeading.text('Member Login');
            }
        });
    });
</script>
</body>
</html>
