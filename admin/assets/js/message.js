window.onload = ()=>{
    if(document.querySelector('.modal-message-container')){


        setTimeout(() => {

            document.querySelector('.modal-message-container').style.animationName = "hideerror";
            
        }, 2000);

    }
}

function showPassword(){
    var passwordbox = document.getElementById("admin-password");
    var showpasswordbutton = document.getElementById("show-password-btn");
    

    if(passwordbox.value !== ""){

        if(passwordbox.type !== "text"){
    
            passwordbox.type = "text";
            showpasswordbutton.innerHTML = '<i class="fas fa-eye-slash"></i>';
            
        }else{
            
            passwordbox.type = "password";
            showpasswordbutton.innerHTML = '<i class="fas fa-eye"></i>';
            
        }
    }
}