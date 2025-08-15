<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Meta Tags -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Title and Favicon -->
    <title>Dashboard — Masjid UIKA</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/school.svg') }}" type="image/x-icon">

    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('assets/modules/select2/dist/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/select2-bootstrap4.css') }}">

    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">

    <!-- External Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body style="background: #e2e8f0">
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <!-- Navbar -->
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li>
                            <a href="#" data-toggle="sidebar" class="nav-link nav-link-lg">
                                <i class="fas fa-bars"></i>
                            </a>
                        </li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">
                    <li class="dropdown">
                        <a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi, {{ auth()->user()->name }}</div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('logout') }}" style="cursor: pointer"
                                onclick="event.preventDefault(); confirmLogout();"
                                class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>

            <!-- Sidebar -->
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="#">MASJID UIKA</a>
                    </div>
                    <ul class="sidebar-menu">
                        <!-- Main Menu -->
                        <li class="menu-header">MAIN MENU</li>
                        <li class="{{ setActive('admin/dashboard') }}">
                            <a class="nav-link" href="{{ route('admin.dashboard.index') }}">
                                <i class="fa-solid fa-gauge-high"></i> <span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Berita Dropdown -->
                        @if (auth()->user()->can('posts.index') || auth()->user()->can('tags.index') || auth()->user()->can('categories.index'))
                            <li class="dropdown {{ setActive(['admin/post', 'admin/tag', 'admin/category']) }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fa-solid fa-newspaper"></i> <span>Berita</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @can('posts.index')
                                        <li class="{{ setActive('admin/post') }}">
                                            <a class="nav-link" href="{{ route('admin.post.index') }}">
                                                <i class="fa-solid fa-book-open"></i> <span>Berita</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('categories.index')
                                        <li class="{{ setActive('admin/category') }}">
                                            <a class="nav-link" href="{{ route('admin.category.index') }}">
                                                <i class="fa-solid fa-folder"></i> <span>Kategori</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('tags.index')
                                        <li class="{{ setActive('admin/tag') }}">
                                            <a class="nav-link" href="{{ route('admin.tag.index') }}">
                                                <i class="fa-solid fa-tags"></i> <span>Tags</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endif

                        <!-- Jadwal Dropdown -->
                        @if (auth()->user()->can('events.index') || auth()->user()->can('leaders.index') || auth()->user()->can('muadzins.index'))
                            <li class="dropdown {{ setActive(['admin/event', 'admin/leader', 'admin/muadzin']) }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fa-solid fa-calendar-days"></i> <span>Jadwal</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @can('events.index')
                                        <li class="{{ setActive('admin/event') }}">
                                            <a class="nav-link" href="{{ route('admin.event.index') }}">
                                                <i class="fa-solid fa-bell"></i> <span>Agenda</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('leaders.index')
                                        <li class="{{ setActive('admin/leader') }}">
                                            <a class="nav-link" href="{{ route('admin.leader.index') }}">
                                                <i class="fa-solid fa-person-praying"></i> <span>Imam</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('muadzins.index')
                                        <li class="{{ setActive('admin/muadzin') }}">
                                            <a class="nav-link" href="{{ route('admin.muadzin.index') }}">
                                                <i class="fa-solid fa-microphone"></i> <span>Muadzin</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endif

                        <!-- Tentang Masjid Dropdown -->
                        @if (auth()->user()->can('managements.index') || auth()->user()->can('services.index') || auth()->user()->can('contacts.index'))
                            <li class="dropdown {{ setActive(['admin/management', 'admin/visi', 'admin/service', 'admin/contact']) }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fa-solid fa-mosque"></i> <span>Tentang Masjid</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @can('managements.index')
                                        <li class="{{ setActive('admin/management') }}">
                                            <a class="nav-link" href="{{ route('admin.management.index') }}">
                                                <i class="fa-solid fa-user-tie"></i> <span>Pejabat</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('managements.index')
                                        <li class="{{ setActive('admin/visi') }}">
                                            <a class="nav-link" href="{{ route('admin.visi.index') }}">
                                                <i class="fa-solid fa-binoculars"></i> <span>Visi dan Misi</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('services.index')
                                        <li class="{{ setActive('admin/service') }}">
                                            <a class="nav-link" href="{{ route('admin.service.index') }}">
                                                <i class="fa-solid fa-handshake"></i> <span>Layanan</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('contacts.index')
                                        <li class="{{ setActive('admin/contact') }}">
                                            <a class="nav-link" href="{{ route('admin.contact.index') }}">
                                                <i class="fa-solid fa-phone"></i> <span>Kontak</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endif

                        <!-- Finance Dropdown -->
                        @if (auth()->user()->can('payment-zakat.index') || auth()->user()->can('enters.index'))
                            <li class="dropdown {{ setActive(['admin/payment-zakat', 'admin/enter', 'admin/out']) }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fa-solid fa-money-bill"></i> <span>Keuangan</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @can('payment-zakat.index')
                                        <li class="{{ setActive('admin/payment-zakat') }}">
                                            <a class="nav-link" href="{{ route('admin.payment-zakat.index') }}">
                                                <i class="fa-solid fa-hand-holding-dollar"></i> <span>Payment Zakat</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('enters.index')
                                        <li class="{{ setActive('admin/enter') }}">
                                            <a class="nav-link" href="{{ route('admin.enter.index') }}">
                                                <i class="fa-solid fa-arrow-trend-up" style="color: #A1C398;"></i>
                                                <span>Uang Masuk</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('enters.index')
                                        <li class="{{ setActive('admin/out') }}">
                                            <a class="nav-link" href="{{ route('admin.out.index') }}">
                                                <i class="fa-solid fa-arrow-trend-down" style="color: #FA7070;"></i>
                                                <span>Uang Keluar</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endif

                        <!-- Mualaf Dropdown -->
                        @can('mualafs.index')
                            <li class="dropdown {{ setActive(['admin/mualaf', 'admin/witness']) }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fa-solid fa-star-and-crescent"></i> <span>Mualaf</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="{{ setActive('admin/mualaf') }}">
                                        <a class="nav-link" href="{{ route('admin.mualaf.index') }}">
                                            <i class="fa-solid fa-user-plus"></i> <span>Mualaf</span>
                                        </a>
                                    </li>
                                    <li class="{{ setActive('admin/witness') }}">
                                        <a class="nav-link" href="{{ route('admin.witness.index') }}">
                                            <i class="fa-solid fa-user-check"></i> <span>Saksi</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        <!-- Kampanye Dropdown -->
                        @can('campaigns.index')
                            <li class="dropdown {{ setActive(['admin/categories_campaign', 'admin/campaign']) }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fa-solid fa-bullhorn"></i> <span>Kampanye</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="{{ setActive('admin/category_campaign') }}">
                                        <a class="nav-link" href="{{ route('admin.category_campaign.index') }}">
                                            <i class="fa-solid fa-folder-open"></i> <span>Kategori Kampanye</span>
                                        </a>
                                    </li>
                                    <li class="{{ setActive('admin/campaign') }}">
                                        <a class="nav-link" href="{{ route('admin.campaign.index') }}">
                                            <i class="fa-solid fa-megaphone"></i> <span>Kampanye</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endcan

                        <!-- Donasi Section -->
                        @can('donations.index')
                            <li class="{{ setActive('admin/donation') }}">
                                <a class="nav-link" href="{{ route('admin.donation.index') }}">
                                    <i class="fa-solid fa-gift"></i> <span>Donatur</span>
                                </a>
                            </li>
                        @endcan

                        <!-- Galeri Dropdown -->
                        @if (auth()->user()->can('photos.index') || auth()->user()->can('videos.index'))
                            <li class="dropdown {{ setActive(['admin/category_photo', 'admin/photo', 'admin/category_video', 'admin/video']) }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fa-solid fa-images"></i> <span>Galeri</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @can('photos.index')
                                        <li class="{{ setActive('admin/category_photo') }}">
                                            <a class="nav-link" href="{{ route('admin.categories_photo.index') }}">
                                                <i class="fa-solid fa-folder"></i> <span>Kategori Foto</span>
                                            </a>
                                        </li>
                                        <li class="{{ setActive('admin/photo') }}">
                                            <a class="nav-link" href="{{ route('admin.photo.index') }}">
                                                <i class="fa-solid fa-image"></i> <span>Foto</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('category_videos.index')
                                        <li class="{{ setActive('admin/category_video') }}">
                                            <a class="nav-link" href="{{ route('admin.category_video.index') }}">
                                                <i class="fa-solid fa-folder"></i> <span>Kategori Video</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('videos.index')
                                        <li class="{{ setActive('admin/video') }}">
                                            <a class="nav-link" href="{{ route('admin.video.index') }}">
                                                <i class="fa-solid fa-video"></i> <span>Video</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endif

                        <!-- Pengaturan Section -->
                        <li class="menu-header">PENGATURAN</li>
                        @can('sliders.index')
                            <li class="{{ setActive('admin/slider') }}">
                                <a class="nav-link" href="{{ route('admin.slider.index') }}">
                                    <i class="fa-solid fa-sliders"></i> <span>Sliders</span>
                                </a>
                            </li>
                        @endcan
                        @if (auth()->user()->can('roles.index') || auth()->user()->can('permission.index') || auth()->user()->can('users.index'))
                            <li class="dropdown {{ setActive(['admin/role', 'admin/permission', 'admin/user']) }}">
                                <a href="#" class="nav-link has-dropdown">
                                    <i class="fa-solid fa-users-gear"></i> <span>Users Management</span>
                                </a>
                                <ul class="dropdown-menu">
                                    @can('roles.index')
                                        <li class="{{ setActive('admin/role') }}">
                                            <a class="nav-link" href="{{ route('admin.role.index') }}">
                                                <i class="fa-solid fa-user-shield"></i> <span>Roles</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('permissions.index')
                                        <li class="{{ setActive('admin/permission') }}">
                                            <a class="nav-link" href="{{ route('admin.permission.index') }}">
                                                <i class="fa-solid fa-key"></i> <span>Permissions</span>
                                            </a>
                                        </li>
                                    @endcan
                                    @can('users.index')
                                        <li class="{{ setActive('admin/user') }}">
                                            <a class="nav-link" href="{{ route('admin.user.index') }}">
                                                <i class="fa-solid fa-user"></i> <span>Users</span>
                                            </a>
                                        </li>
                                    @endcan
                                </ul>
                            </li>
                        @endif
                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            @yield('content')

            <!-- Footer -->
            <footer class="main-footer">
                <div class="footer-left">
                    Copyright © 2024 <div class="bullet"></div> SIMAS <div class="bullet"></div> All Rights Reserved.
                </div>
                <div class="footer-right"></div>
            </footer>
        </div>
    </div>

    <!-- JavaScript Files -->
    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/modules/select2/dist/js/select2.full.min.js') }}"></script>

    <!-- Template JS Files -->
    <script src="{{ asset('assets/js/stisla.js') }}"></script>
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>

    <!-- Inline JavaScript -->
    <script>
        // Initialize Select2
        $(document).ready(function() {
            $('select').select2({
                theme: 'bootstrap4',
                width: 'style',
            });
        });

        // Flash Messages
        @if (session()->has('success'))
            swal({
                type: "success",
                icon: "success",
                title: "BERHASIL!",
                text: "{{ session('success') }}",
                timer: 1500,
                showConfirmButton: false,
                showCancelButton: false,
                buttons: false,
            });
        @elseif (session()->has('error'))
            swal({
                type: "error",
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                timer: 1500,
                showConfirmButton: false,
                showCancelButton: false,
                buttons: false,
            });
        @endif

        // Confirm Logout
        function confirmLogout() {
            swal({
                title: "Apakah Anda Yakin?",
                text: "Anda akan keluar dari aplikasi",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willLogout) => {
                if (willLogout) {
                    document.getElementById('logout-form').submit();
                }
            });
        }
    </script>
</body>

</html>