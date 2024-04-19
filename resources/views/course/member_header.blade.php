<?php
//include_once "../db_conn.php";
//if(!isset($_SESSION['member_id']) || $_SESSION['member_id']<1) {
//    header("Location: ../index.php");
//}
//$sql = "SELECT * FROM members WHERE id_members=" . $_SESSION['member_id'] . " LIMIT 1";
//$result = $conn->query($sql);
//$member = $result->fetch_assoc();
//?><!---->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'BP-SB Exam module')</title>

    <link rel="icon" href="{{ asset('assets/image/police-logo.jpg') }}" />
    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600&family=Nunito:wght@600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.maateen.me/adorsho-lipi/font.css" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <!-- Bootstrap CDN link -->
    <!-- Customized Bootstrap Stylesheet -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

    <link href="{{asset('assets/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <!-- Libraries Stylesheet -->
    <link href="{{asset('assets/lib/animate/animate.min.css')}}" rel="stylesheet">
    <link href="{{asset('assets/lib/owlcarousel/assets/owl.carousel.min.css')}}" rel="stylesheet">



    <!-- Template Stylesheet -->
    <link href="{{asset('assets/css/custom.css')}}">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <style>
        body, .btn, h1, h2, h3, h4, h5, h6 {
            font-family: 'AdorshoLipi', 'Times New Roman', sans-serif !important;
        }
    </style>

</head>

<body>
@php
$member=\Illuminate\Support\Facades\Auth::guard('member')->user();
 @endphp
<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg bg-white navbar-light shadow sticky-top px-0 py-2">
    <a href="#" class="navbar-brand d-flex align-items-center px-4 px-lg-5">
        <img style="height: 100px;width: 100px" src="{{asset("assets/image/police-logo.jpg")}}" alt="Logo" id="logo_main">
    </a>
    <button type="button" class="navbar-toggler me-4" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <div class="navbar-nav ms-auto p-4 p-lg-0">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"><i class="fas fa-user-circle"></i> <?= $member['name_bn'] ?></a>
                <div class="dropdown-menu fade-down m-0" style="right: 20%">
                    <form method="POST" action="{{ route('logout') }}" class="dropdown-item alert-danger">
                        @csrf
                        <button type="submit" style="border: none; background: none; cursor: pointer;">
                            <i class="fas fa-sign-out-alt"></i> লগ আউট
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</nav>







    <!-- Navbar End -->
