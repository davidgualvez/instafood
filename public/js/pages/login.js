$(document).ready(function () {
    console.log('loaded...');
    if(isLogin()){
        redirectTo('/groups');
        return;
    }
});

function btnLogin(){
    $('#btn-login').on('click', function(){
        console.log('clicked...');
        var username = $('#username');
        var password = $('#password');
        
        if(username.val().trim() == '' ||
            username.val().trim() == null){
                showWarning('','Username is required', function(){

                });
                return;
            }

        if (password.val().trim() == '' ||
            password.val().trim() == null) {
            showWarning('', 'Password is required', function () {

            });
            return;
        }

        console.log('everything is okay...');
        login(
            username.val(),
            password.val()
        );

    });
}

function login(username, password){
    var data = {
        username : username,
        password : password
    };

    post(routes.login, data, function(response){
        if(response.success == false){
            showWarning('',response.message, function(){

            });
            return;
        }

        setStorage('token', response.token);
        setStorage('name', response.name);
        setStorage('outlet_id', response.data.outlet.id);
        setStorage('outlet_name', response.data.outlet.name);
        setStorage('order_slip',null);
        
        showSuccess('', 'Login Success', function () {
            redirectTo('/groups');
        }); 

    });
}