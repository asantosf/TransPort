
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    @include('layouts.librerias')

</head>

<body background="{{ asset('img/logo1.jpg') }}" 
    style = 
    "
        opacity: 0.90;
        background-position-x:center;
        background-position-y:center;
        background-size: 125rem;
        background-color: rgb(138, 228, 231); 
    ">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-6 col-lg-12">
                <br><br><br><br><br><br><br><br>
                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Bienvenido</h1>
                                    </div>
                                    <form class="user" method="POST" action="{{ route('loginAuth') }}">
                                        {{ csrf_field() }}
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user {{ $errors->has('email') ? 'has-error' : '' }}"
                                                id="email" name="email" aria-describedby="emailHelp"
                                                placeholder="ejemplo@correo.com..." value="{{ old('email') }}">
                                                {!!  $errors->first('email',  '<span class="help-block">:message</span>') !!}
                                        </div>
                                        <div class="form-group">
                                            <input type="password" class="form-control form-control-user {{ $errors->has('password') ? 'has-error' : '' }}"
                                                id="password" name="password" placeholder="Contraseña...">
                                                {!!  $errors->first('password',  '<span class="help-block">:message</span>') !!}
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block">Login</button>
                                    </form>
                                    <hr>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    @include('layouts.scripts')

</body>

</html>