<?php
$text_align = app()->getLocale() == 'ar' ? 'text-right' :'';
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Register Employee</title>

    <!-- Custom fonts for this template-->
    <link href="{{ asset('backend/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{ asset('backend/css/sb-admin-2.min.css') }}" rel="stylesheet">

    <style>
        .form-select:invalid {
            color: gray;
        }

        option[value=""][disabled] {
            display: none;
        }

        option {
            color: black;
        }

        select.form-select.form-control.form-control-user {
            padding: .75rem 1.5rem;
            border-radius: 10rem;
            background-color: #f8f9fc;
            height: auto;
        }
    </style>
</head>

<body class="bg-gradient-primary">

<div class="container">
    <!-- Outer Row -->
    <div class="row justify-content-center">
        <div class="col-xl-10 col-lg-12 col-md-9 mt-5">
            <div class="card o-hidden border-0 shadow-lg my-5 ">
                <div class="card-body p-5 ">
                <div class="text-center">
                <h1 class="h4 text-gray-900 mb-4">@lang('showfileandtypes.Register_new_user')</h1>
                </div>
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                            <form class="user" method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="form-group">
                                    <input name="first_name" type="text" class="form-control form-control-user {{$text_align}}" id="exampleFirstName"
                                        placeholder="@lang('showfileandtypes.first_name')" value="{{ old('first_name') }}" required>
                                </div>

                                <div class="form-group">
                                    <input name="last_name" type="text" class="form-control form-control-user {{$text_align}}" id="exampleLastName"
                                        placeholder="@lang('showfileandtypes.last_name')" value="{{ old('last_name') }}" required>
                                </div>

                                <div class="form-group ">
                                    <input name="phone_number" type="text" class="form-control form-control-user {{$text_align}}" id="examplePhoneNumber"
                                        placeholder="@lang('showfileandtypes.Phone_Number')" value="{{ old('phone_number') }}" required>
                                </div>

                                <div class="form-group ">
                                    <input name="email" type="email" class="form-control form-control-user {{$text_align}}" id="exampleInputEmail"
                                        placeholder="@lang('showfileandtypes.Email_Address')" value="{{ old('email') }}" required>
                                </div>
                                @if (app()->getLocale() == 'en')
                                <div class="form-group row ">
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="password" type="password" class="form-control form-control-user {{$text_align}}"
                                            id="exampleInputPassword" placeholder="@lang('showfileandtypes.Password')" required>
                                    </div>
                                    <div class="col-sm-6 ">
                                        <input name="password_confirmation" type="password" class="form-control form-control-user {{$text_align}}"
                                            id="exampleRepeatPassword" placeholder="@lang('showfileandtypes.Repeat_Password')" required>
                                    </div>
                                </div>
                                @else
                                <div class="form-group row ">
                                    <div class="col-sm-6 ">
                                        <input name="password_confirmation" type="password" class="form-control form-control-user {{$text_align}}"
                                            id="exampleRepeatPassword" placeholder="@lang('showfileandtypes.Repeat_Password')" required>
                                    </div>
                                    <div class="col-sm-6 mb-3 mb-sm-0">
                                        <input name="password" type="password" class="form-control form-control-user {{$text_align}}"
                                            id="exampleInputPassword" placeholder="@lang('showfileandtypes.Password')" required>
                                    </div>
                                </div>
                                @endif
                                <div class="form-group ">
                                    <select class="form-select form-control form-control-user {{$text_align}}" id="department" name="department" required>
                                        <option value="" disabled selected>@lang('showfileandtypes.Select_Department')</option>
                                        @foreach ($departments as $department)
                                            <option value="{{ $department->id }}">{{ $department->department }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                @lang('showfileandtypes.Register_Account')
                                </button>
                            </form>
                            <hr>
                        </div>
                </div>
                </div>
    </div>
    

    <!-- Bootstrap core JavaScript-->
    <script src="{{ asset('backend/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('backend/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript-->
    <script src="{{ asset('backend/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages-->
    <script src="{{ asset('backend/js/sb-admin-2.min.js') }}"></script>

</body>

</html>
