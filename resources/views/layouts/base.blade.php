<!doctype html>
 <html lang="en">
 <head>
 <meta charset="UTF-8">
 <title></title>
 </head>
 <body>
 @yield('body')
 @include('layouts.header')
 <script src="{{ asset('vendor/datatables/buttons.server-side.js') }}"></script>
@stack('scripts')
 </body>
 </html>