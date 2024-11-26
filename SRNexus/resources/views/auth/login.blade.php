<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>SRNEXUS | Inicio Sesión</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/admin-lte/2.4.18/css/AdminLTE.min.css">
    <!-- iCheck -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/blue.css">

    <style>
        .bglogin {
            background-image: url("{{ asset('img/wp.jpg') }}");
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
            position: relative;
            overflow-y: hidden;
        }

        .login-box {
            border-radius: 15px; /* Bordes redondeados */
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.3); /* Sombra para relieve */
        }

        .login-logo img {
            border-radius: 15px; /* Bordes redondeados también para la imagen */
        }

        .x-icon {
            height: 1em;
            width: 1em;
            top: .125em;
            position: relative;
        }

    </style>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@400;600&display=swap" rel="stylesheet">
</head>

<body class="hold-transition login-page bglogin">
    <div class="login-box">
        <div class="login-logo">
            <img src="{{ asset('img/logo_blanco_sombra.png') }}" class="responsive" width="50%">
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            <p class="login-box-msg">Bienvenido al Sistema <b>SRNEXUS</b></p>
            <form action="{{ route('login') }}" method="post">
                @csrf <!-- Protección CSRF -->

                <!-- Campo para el correo -->
                <div class="input-group">
                    <input id="email" name="email" type="email" class="form-control" placeholder="Correo electrónico"
                        value="{{ old('email') }}" required autofocus>
                    <span class="input-group-addon"><i class="fa fa-envelope"></i></span>
                </div>
                @if ($errors->has('email'))
                    <div class="form-group has-error">
                        <span class="help-block">{{ $errors->first('email') }}</span>
                    </div>
                @endif
                <br>

                <!-- Campo para la contraseña -->
                <div class="input-group">
                    <input id="password" name="password" type="password" class="form-control"
                        placeholder="Contraseña" required>
                    <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                </div>
                @if ($errors->has('password'))
                    <div class="form-group has-error">
                        <span class="help-block">{{ $errors->first('password') }}</span>
                    </div>
                @endif
                <br>

                <!-- Botón de inicio de sesión -->
                <div class="row">
                    <div class="col-xs-8">
                        <!-- Espacio para añadir una opción de recordar usuario -->
                    </div>
                    <!-- /.col -->
                    <div class="col-xs-4">
                        <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
                    </div>
                    <!-- /.col -->
                </div>

            </form>

        </div>
        <!-- /.login-box-body -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery 3 -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
    <!-- iCheck -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>

    <script>
        $(function() {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' // optional
            });
        });
    </script>
</body>

</html>

{{-- @extends('adminlte::auth.auth-page', ['auth_type' => 'login'])
@section('auth_header', __('Bienvenido al SRNexus'))
 --}}
{{--
@section('auth_body')
    <form action="{{ route('login') }}" method="post">
        @csrf

        <!-- Campo de correo -->
        <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Correo electrónico" required autofocus>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-envelope"></span>
                </div>
            </div>
        </div>

        <!-- Campo de contraseña -->
        <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Contraseña" required>
            <div class="input-group-append">
                <div class="input-group-text">
                    <span class="fas fa-lock"></span>
                </div>
            </div>
        </div>

        <!-- Botón de inicio de sesión -->
        <div class="row">
            <div class="col-8">
                <!-- Opción de recordar usuario -->
                <div class="icheck-primary">
                    <input type="checkbox" id="remember" name="remember">
                    <label for="remember">Recordarme</label>
                </div>
            </div>
            <div class="col-4">
                <button type="submit" class="btn btn-primary btn-block">Ingresar</button>
            </div>
        </div>
    </form>
@endsection --}}
{{--
@section('auth_footer')
    <!-- Enlaces adicionales, si es necesario -->
@endsection --}}
