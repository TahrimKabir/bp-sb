
@extends('dashboard')
@section('main')
    @parent

    <!-- Content Wrapper. Contains page content -->
@section('edit')
<div class="content-wrapper">


<!-- Main content -->
<section class="content p-4">
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 justify-content-center">
                <div class="card">
                    <div id="message-container">
                        @if (session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('fail'))
                        <div class="alert alert-danger">
                            {{ session('fail') }}
                        </div>
                    @endif
                    </div>
                    <div class="card-header clr-dark-green">

                        <h3 class="text-center display-6 mb-0">
                        Create New Admin
                        </h3>
                    </div>
                    <div class="card-body">
                    <form method="POST" action="{{ route('admin.store') }}">
    @csrf

    <div class="form-group">
        <label for="name">Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
        <span class="text-danger" id="name_error"></span>
        @if ($errors->has('name'))
            <span class="text-danger">{{ $errors->first('name') }}</span>
        @endif
    </div>

    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required>
        <span class="text-danger" id="email_error"></span>
        @if ($errors->has('email'))
            <span class="text-danger">{{ $errors->first('email') }}</span>
        @endif
    </div>

    <div class="form-group">
        <label for="password">Password</label>
        <input type="password" class="form-control" id="password" name="password" required>
        <span class="text-danger" id="password_error"></span>
        @if ($errors->has('password'))
            <span class="text-danger">{{ $errors->first('password') }}</span>
        @endif
    </div>

    <div class="form-group">
        <label for="password_confirmation">Confirm Password</label>
        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        <span class="text-danger" id="password_confirmation_error"></span>
        @if ($errors->has('password_confirmation'))
            <span class="text-danger">{{ $errors->first('password_confirmation') }}</span>
        @endif
    </div>

    <button type="submit" class="btn btn-primary">Create Admin</button>
</form>




                    </div>

                </div>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!--  -->
@endsection
@endsection

@section('script')
    <script src="{{asset('plugins/jquery/jquery.min.js')}}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <!-- AdminLTE App -->
    <script src="{{asset('dist/js/adminlte.min.js')}}"></script>
    <script>

$(document).ready(function () {
    $('#name, #email, #password, #password_confirmation').on('input', function () {
        let name = $('#name').val();
        let email = $('#email').val();
        let password = $('#password').val();
        let passwordConfirmation = $('#password_confirmation').val();

        let errors = {
            name: '',
            email: '',
            password: '',
            password_confirmation: ''
        };

        // Clear existing errors
        $('#name_error').text('');
        $('#email_error').text('');
        $('#password_error').text('');
        $('#password_confirmation_error').text('');

        // Validate name
        if (name.length < 3) {
            errors.name = 'Name must be at least 3 characters long.';
            $('#name_error').text(errors.name);
        }

        // Validate email
        let emailPattern = /^[a-zA-Z0-9_.+-]+@[a-zA-Z0-9-]+\.[a-zA-Z0-9-.]+$/;
        if (!emailPattern.test(email)) {
            errors.email = 'Please enter a valid email address.';
            $('#email_error').text(errors.email);
        }

        // Validate password
        if (password.length < 8) {
            errors.password = 'Password must be at least 8 characters long.';
            $('#password_error').text(errors.password);
        }

        // Validate password confirmation
        if (password !== passwordConfirmation) {
            errors.password_confirmation = 'Passwords do not match.';
            $('#password_confirmation_error').text(errors.password_confirmation);
        }

        // Optionally disable submit button if there are errors
        if (errors.name || errors.email || errors.password || errors.password_confirmation) {
            $('button[type="submit"]').attr('disabled', 'disabled');
        } else {
            $('button[type="submit"]').removeAttr('disabled');
        }
    });
});


</script>
@endsection