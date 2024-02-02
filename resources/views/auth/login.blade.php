
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>BPWN | Admin Login</title>
    <link rel="shortcut icon" href="{{asset('images/logo.png')}}" type="image/x-icon">
    <style>
        .divider:after,
        .divider:before {
            content: "";
            flex: 1;
            height: 1px;
            background: #eee;
        }
        .h-custom {
            height: calc(100% - 73px);
        }
        @media (max-width: 450px) {
            .h-custom {
                height: 100%;
            }
        }
        .vh-100 {
            min-height: 100vh;
        }
    </style>
</head>
<body>
    <section class="vh-100 d-flex flex-column justify-content-between">
    <div
        class="d-flex flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-secondary">
        <!-- Header -->
        <a href="login.php" class="nav-link">
            <div class="d-flex align-items-center">
                <img src="{{asset('images/logo.png')}}" height="60px" alt="Logo">
            </div>
        </a>
        <!-- Header -->
    </div>
    <div class="container-fluid h-custom">
        <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-md-9 col-lg-6 col-xl-5 px-5 py-4 py-sm-2">
            <img src="{{asset('images/logo.png')}}" class="img-fluid mx-auto" alt="Logo" style="max-height: 150px;">
        </div>
        <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
            <form method="POST" action="{{ route('login') }}">
                @csrf


            <!-- Email input -->
            <div class="form-outline mb-4">
            <label class="form-label" for="form3Example3">ইমেল</label>
                <input type="email" id="form3Example3" class="form-control form-control"
                placeholder="ইমেল লিখুন" name="email" required @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}"  autocomplete="email" autofocus/>

                

                @error('email')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
               
            </div>

            <!-- Password input -->
            <div class="form-outline mb-3">
            <label class="form-label" for="form3Example4"> পাসওয়ার্ড </label>
                <input type="password" id="form3Example4" class="form-control form-control"
                placeholder="পাসওয়ার্ড লিখুন" name="password" required @error('password') is-invalid @enderror"   autocomplete="current-password"/>
                
            </div>

            <div class="text-center">
                @error('password')
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                </span>
            @enderror
               
            </div>

            <div class="text-center text-lg-start mt-4 pt-2">
                <input type="submit" value="লগইন" class="btn btn-primary" style="padding-left: 2.5rem; padding-right: 2.5rem;" name="admin_login">

            </div>

            </form>
        </div>
        </div>
    </div>
    <div
        class="d-flex flex-column flex-md-row text-center text-md-start justify-content-between py-4 px-4 px-xl-5 bg-secondary">
        <!-- Copyright -->
        <p class="copyright text-white">
        Copyright &copy; <script data-cfasync="false" src="../../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script>document.write(new Date().getFullYear());</script> All rights reserved | BPWN</a>
        </p>
        <!-- Copyright -->
    </div>
    </section>
</body>
</html>

