<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bg Collection Store Mangement Application</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/BG-Collection-logo-.png') }}">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/bracket.css') }}">
    <style>
        .is-invalid {
            outline: 1px solid #d63384;
        }
    </style>
</head>

<body>
    <div class="d-flex align-items-center justify-content-center bg-br-primary ht-100v">
        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white rounded shadow-base">
            <div class="signin-logo tx-center tx-28 tx-bold tx-inverse"><span class="tx-normal">[</span> Bg Collection
                <span class="tx-normal">]</span>
            </div>
            <div class="tx-center mg-b-60">User Login</div>
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="form-group">
                    <input type="email" name="email" value="{{ old('email') }}" required autocomplete="email"
                        autofocus class="form-control" placeholder="Enter your email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" class="form-control @error('password') is-invalid @enderror" name="password"
                        required autocomplete="current-password" placeholder="Enter your password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="d-flex align-items-center">
                        <div>
                            <input class="custom-control" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        </div>
                        <div>
                            <p class="tx-info tx-15 d-block mg-t-10">Remember Me</p>
                        </div>
                    </label>
                </div>
                <button type="submit" class="btn btn-info btn-block">Sign In</button> 
            </form>
        </div>
    </div>
</body>

</html>
