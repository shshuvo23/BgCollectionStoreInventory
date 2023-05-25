<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Bg Collection-{{ isset($page_title) ? $page_title : 'Store Management Application' }}</title>
    <link href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/BG-Collection-logo-.png') }}">
    <link href="{{ asset('assets/lib/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">

    @yield('css')
    <link rel="stylesheet" href="{{ asset('assets/css/bracket.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/customModal.css') }}">
    @vite(['resources/js/app.js'])
    <style>
        #app {
            position: relative;
        }

        .f-bottom {
            position: absolute;
            bottom: 0;
        }

        .bg-grey {
            background-color: rgb(218, 217, 217);
        }

        .bg-white {
            background-color: white;
        }
    </style>
</head>


{{-- // const { defineConfig } = require("@vue/cli-service");
// module.exports = defineConfig({
//   transpileDependencies: true,
//   lintOnSave: false,
// });
// module.exports = {
//   devServer: {
//     proxy: 'https://localhost/backend/'
//   }
// } --}}




<body>
    <div id="app">
        @include('layouts.sidebar')
        @include('layouts.nav')

        <div class="br-mainpanel" style="position: relative;">
            <div class="pd-30">
                <h4 class="tx-gray-800 mg-b-5">{{ isset($page_title) ? $page_title : '' }}</h4>
                <p class="mg-b-0">{{ isset($page_message) ? $page_message : '' }}</p>
            </div>
            @yield('content')
            <footer class="br-footer ">
                <div class="f-bottom" style="text-align:center; padding:10px 0; ">
                    <div class="mg-b-2">Copyright &copy; {{ date('Y') }}. BG Collection. All Rights Reserved.</div>
                </div>
            </footer>
        </div>

    </div>










    @if (notificationSeenStatus())
        <div class="custom-modal" id="successMessage">
            <div class="custom-modal-content mt-5 center">
                <div class="custom-modal-icon">
                    <i class="fa-solid fa-circle-check"></i>
                </div>
                <div class="row my-2 modal-message">
                    <div class=" col-md-12 col-sm-12">
                        {{-- <h4 class="text-center mb-3">you have........... </h4> --}}
                        <h5 class=" text-center">New Notification</h5>
                    </div>
                </div>
                <div class="text-center mt-4 mt-3">
                    <button id="okHide" onclick="heidCustomModal()" class="text-center  btn btn-sm px-3 btn-primary"
                        data-toggle="dropdown">ok</button>
                </div>

                {{-- <a  href="" class="nav-link pd-x-7 pos-relative" data-toggle="dropdown">
                    <i class="icon ion-ios-bell-outline tx-24"></i>
                    @if (unreadNotification())
                    <span class="square-8 bg-danger pos-absolute t-15 r-5 rounded-circle"></span>
                    @endif
                </a> --}}
            </div>
        </div>
    @endif


    <script src="https://code.jquery.com/jquery-3.6.1.min.js"></script>
    <script src="{{ asset('assets/lib/popper.js/popper.js') }}"></script>
    <script src="{{ asset('assets/lib/bootstrap/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.js') }}"></script>
    <script src="{{ asset('assets/js/bracket.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/customModal.js') }}"></script> --}}
    <script src="{{ asset('assets/js/monthAndYearPicker.js') }}"></script>
    @yield('js')

    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>


    <script>
        let modal = document.querySelector('.custom-modal');
        let button = document.querySelector('#okHide');

        function heidCustomModal() {
            document.getElementById("notificationButton").click();
            modal.style.display = 'none';
            seenNotification();

        }
    </script>

    <script>
        function seenNotification() {
            $.get('{{ route('seen_notification_alert') }}', function() {});
        }
    </script>

    <script>
        // document.getElementById("notificationButton").click();
        function success(message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: message
            })
        }

        function error(message) {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'error',
                title: message
            })
        }
    </script>



    @if (session('success'))
        <script>
            success('{{ session('success') }}');
        </script>
    @endif
    @if (session('error'))
        <script>
            error('{{ session('error') }}');
        </script>
    @endif
    @if (session('errorSweet'))
        <script>
            Swal.fire(
                'Warning!',
                '{{ session('errorSweet') }}',
                'warning'
            );
        </script>
    @endif
    <script>
        function deleteItem(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You you want to delete this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $('#deleteItem' + id).submit()
                }
            })
        }

        function confirmData(functionName, msgOne = '', msgTwo = '') {
            var message = '';
            message += " <h3 style='color:#dc3545'>  " + msgOne + "</h3>"
            message += " <h3 style='color:#dc3545'>  " + msgTwo + "</h3>"
            Swal.fire({
                title: 'Are you sure?',
                html: message,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, submit it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    functionName();
                }
            })
        }
    </script>
    <script>
        function onlyPositive(id, min = 1) {

            let value = $('#' + id).val();
            if (value != null && value != "" && value < min) {
                $('#' + id).val(min);
            }
        }
    </script>

</body>

</html>
