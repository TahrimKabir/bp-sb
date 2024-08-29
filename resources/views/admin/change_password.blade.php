
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

                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                    </div>
                    <div class="card-header clr-dark-green">

                        <h3 class="text-center display-6 mb-0">
                        Change Password
                        </h3>
                    </div>
                    <div class="card-body">

    
    <form action="{{ route('admin.update_password') }}" method="POST">
        @csrf
        <div class="form-group">
    <label for="current_password">Current Password</label>
    <input type="password" class="form-control" id="current_password" name="current_password" required>
    <span class="text-danger" id="current_password_error"></span>
</div>
<div class="form-group">
    <label for="new_password">New Password</label>
    <input type="password" class="form-control" id="new_password" name="new_password" required>
    <span class="text-danger" id="new_password_error"></span>
</div>
<div class="form-group">
    <label for="new_password_confirmation">Confirm New Password</label>
    <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
    <span class="text-danger" id="new_password_confirmation_error"></span>
</div>

        <button type="submit" class="btn btn-primary">Change Password</button>
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
    $('#current_password, #new_password, #new_password_confirmation').on('input', function () {
        let currentPassword = $('#current_password').val();
        let newPassword = $('#new_password').val();
        let newPasswordConfirmation = $('#new_password_confirmation').val();

        let errors = {
            current_password: '',
            new_password: '',
            new_password_confirmation: ''
        };

        // Clear existing errors
        $('#current_password_error').text('');
        $('#new_password_error').text('');
        $('#new_password_confirmation_error').text('');

        // Validate current password (You can add an AJAX call here if needed)
        if (currentPassword.length < 8) {
            errors.current_password = 'Current password must be at least 8 characters long.';
            $('#current_password_error').text(errors.current_password);
        }

        // Validate new password
        if (newPassword.length < 8) {
            errors.new_password = 'New password must be at least 8 characters long.';
            $('#new_password_error').text(errors.new_password);
        }

        // Validate password confirmation
        if (newPassword !== newPasswordConfirmation) {
            errors.new_password_confirmation = 'Passwords do not match.';
            $('#new_password_confirmation_error').text(errors.new_password_confirmation);
        }

        // Optionally disable submit button if there are errors
        if (errors.current_password || errors.new_password || errors.new_password_confirmation) {
            $('button[type="submit"]').attr('disabled', 'disabled');
        } else {
            $('button[type="submit"]').removeAttr('disabled');
        }
    });
});
</script>
@endsection