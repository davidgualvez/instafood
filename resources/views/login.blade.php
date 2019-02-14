<!DOCTYPE html>
<html>
<head> 
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" /> 
	<meta name=viewport content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="/favico.png" />
    <title>Login | Enchanted Kingdom</title>

	<!-- CSS -->
	<link rel="stylesheet" type="text/css" href="/dist/semantic.min.css"> 
	<link rel="stylesheet" type="text/css" href="/css/plugins/introjs.min.css">
    <link rel="stylesheet" type="text/css" href="/css/plugins/iziToast.min.css">
	<link rel="stylesheet" type="text/css" href="/css/config.css">
	<!-- CUSTOM CSS --> 
	<style type="text/css">
		body {
		     background-color: #393e46;
		   }
		   body > .grid {
		     height: 100%;
		   }
		   .image {
		     margin-top: -100px;
		   }
		   .column {
		     max-width: 450px;
		   }
	</style>
</head>
<body>  
    <!-- CONTENT -->
    <div class="ui middle aligned center aligned grid ">
        <div class="column g-padding">
        <h2 class="ui teal image header">
            <img src="assets/images/cropped-EK-Fav2018-192x192.png" class="image">
            <div class="content">
            Enchanted Kingdom
            </div>
        </h2>
        
        {{-- <div class="ui segment">
                <div style=" display:block; text-align:left;">
                    <div class="ui small breadcrumb">
                        <a href="/" class="section step3">
                            <i class="home icon"></i>
                            Home
                        </a>
                        <i class="right chevron icon divider"></i> 
                        <div class="active section">Employee Login</div>
                    </div>
                </div> 
        </div> --}}

        <div class="ui large form">
            <div class="ui stacked segment">  

            <div class="field" >
                    <label class="" style="text-align: left;">Username</label>
                <div class="ui left icon input">
                    <i class="user icon"></i>
                    <input  type="text" id="username" placeholder="Username...">
                </div>
            </div>

            <div class="field">
                <label class="" style="text-align: left;">Password</label>
                <div class="ui left icon input">
                    <i class="lock icon"></i>
                    <input type="password" id="password" placeholder="Password...">
                </div>
            </div>

            {{-- <div class="field">
                <label class="" style="text-align: left;"> <small><a href="/forgot-password">Forgot Password?</a></small> </label> 
            </div> --}}

            <button id="btn-login" class="ui fluid large teal submit button">Login</button>   
            </div>  
        </div> 

        {{-- <div class="ui message">
            Don't have account yet? <a href="/signup" class="step2">Sign Up</a>
        </div> --}}
        </div>
    </div>
    <!-- END CONTENT -->  

	<!-- JS -->
	<script src="/js/app.js"></script>
	<script src="/dist/semantic.min.js"></script>
	<script src="/js/plugins/intro.min.js"></script>
    <script src="/js/plugins/iziToast.min.js"></script>
	<script src="/js/config.js"></script>
	<!-- CUSTOM JS --> 
	<script src="/js/pages/login.js"></script> 
</body>
</html> 