<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ __('default.User App') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    </head>
    <body>
        <div id="app" data-csrf="{{ csrf_token() }}"></div>

        <script type="text/javascript">
            window.appConfig = {
                locales : {
                    route : "{{ route('locales') }}",
                    code  : "{{ app()->getLocale() }}"
                },
                routes : {
                    login       : "{{ route('user.login') }}",
                    logout      : "{{ route('user.logout') }}",
                    register    : "{{ route('user.register') }}",
                    check       : "{{ route('user.check') }}",
                    user_grid   : "{{ route('user.grid') }}",
                    user_edit   : "{{ route('user.update', ['id' => '?']) }}",
                    user_delete : "{{ route('user.destroy', ['id' => '?']) }}"
                }
            }

        </script>
        <script type="text/javascript" src="{{ asset('js/app.js') }}"></script>
    </body>
</html>

