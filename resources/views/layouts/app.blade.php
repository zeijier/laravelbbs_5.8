<html lang="{{app()->getLocale()}}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token  csrf-token 标签是为了方便前端的 JavaScript 脚本获取 CSRF 令牌。-->
    <meta name="csrf-token" content="{{csrf_token()}}">
    <title>@yield('title','laraBBS') - Laravel 进阶</title>
    <!-- Styles -->
    <link href="{{mix('css/app.css')}}" rel="stylesheet">
</head>
<body>
<div id="app" class="{{route_class()}}-page">
@include('layouts._header')
    <div class="container">
        @include('shared._messages')
        @yield('content')
    </div>
    @include('layouts._footer')
</div>
<!-- Scripts -->
<script src="{{mix('js/app.js')}}"></script>
</body>

</html>