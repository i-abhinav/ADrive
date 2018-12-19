<!DOCTYPE html>
<html lang="en">
    <!-- BEGIN HEAD -->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
        <meta name="description" content="Cloud based File Management">
        <meta name="author" content="Abhinav Gupta">
        <meta name="keyword" content="File, Folder, Bootstrap, Laravel, Cloud">
        <title>User Signup</title>
        <!-- BEGIN GLOBAL MANDATORY STYLES -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
        {{-- <!-- <link href="{{ asset("/assets/global/plugins/font-awesome/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" /> --> --}}
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
        <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
        <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js"></script>
        <script defer src="https://use.fontawesome.com/releases/v5.0.13/js/solid.js" integrity="sha384-tzzSw1/Vo+0N5UhStP3bvwWPq+uvzCMfrN1fEFe+xBmv1C/AtVX5K0uZtmcHitFZ" crossorigin="anonymous"></script>
        <link href="{{ asset("/css/style.css")}}" rel="stylesheet" type="text/css" />

        @yield('css')
    </head>
    <!-- END HEAD -->
    <body class="app flex-row align-items-center">
        <div class="container">

            @yield('content')

        </div>

        @yield('script')

    </body>
</html>
