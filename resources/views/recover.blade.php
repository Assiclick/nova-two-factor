<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      class="h-full font-sans antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token"
          content="{{ csrf_token() }}">

    <title>{{ Nova::name() }}</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,800,800i,900,900i"
          rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet"
          href="{{ mix('app.css', 'vendor/nova') }}">

    <!-- Custom Meta Data -->
    @include('nova::partials.meta')

    <!-- Theme Styles -->
    @foreach (\Laravel\Nova\Nova::themeStyles() as $publicPath)
        <link rel="stylesheet"
              href="{{ $publicPath }}">
    @endforeach

    <script>
        function checkAutoSubmit(el) {
            if (el.value.length === 6) {
                document.getElementById('authenticate_form').submit();
            }
        }
    </script>
</head>

<body class="h-full text-black bg-grad-sidebar">
    <div class="h-full">
        <div class="mx-auto px-view py-view">

            @include('nova::auth.partials.header')

            <form class="p-8 mx-auto bg-white rounded-lg shadow max-w-login"
                  method="POST"
                  action="{{ route('nova-two-factor.recover') }}">
                @csrf

                @component('nova::auth.partials.heading')
                    {{ __('Sign in with recovery code') }}
                @endcomponent


                @if ($errors->any())
                    <p class="my-3 font-semibold text-center text-danger">
                        {{ $errors->first() }}
                    </p>
                @endif

                <div class="mb-6 ">
                    <label class="block mb-2 font-bold"
                           for="password">{{ __('Recovery code') }}</label>
                    <input class="w-full form-control form-input form-input-bordered"
                           id="password"
                           type="text"
                           name="recovery_code"
                           required>
                </div>

                <div class="flex mb-6">
                    <div class="ml-auto">
                        <a class="font-bold no-underline text-primary dim"
                           href="{{ config('nova.path') }}">
                            {{ __('Use OTP code') }}
                        </a>
                    </div>
                </div>

                <button class="w-full btn btn-default btn-primary hover:bg-primary-dark"
                        type="submit">
                    {{ __('Proceed') }}
                </button>
            </form>
        </div>
    </div>
</body>

</html>
