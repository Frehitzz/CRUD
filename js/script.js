function pass_manage() {
    // get the id of the input
    const passInput = document.getElementById('login-pass');
    // get the id of the our eye icon id
    const eyeIcon = document.getElementById('toggle-pass');
    
    /*
    checking if our input have a type of password,
    if it have then the code inside of the if statement
    will work
    */
    if (passInput.type === "password") {

        /* here we make the input have a type of text this is to see the
           password that the user put or type */
        passInput.type = "text";

        /*here on our icon we use a classList property to use the .add and .remove
          then inside of the "( )" are the classname of the icon*/
        eyeIcon.classList.remove('fa-eye');
        eyeIcon.classList.add('fa-eye-slash');

        
    } else { // the the input type of our input is not password then the code will run

        /*here on else statement we declare the type as a password
          because in the else statement when this code runs that means that the type is not equal to password
          so we declare this to make the input type password*/
        passInput.type = "password";

        /*binaliktad lang yung nasa if statement*/
        eyeIcon.classList.remove('fa-eye-slash');
        eyeIcon.classList.add('fa-eye');
    }
}

function passcheckb_manage(){
    const passInput = document.getElementById('signup-pass');
    const confirmpassInput = document.getElementById('signup-pass-confirm');
    
    if(passInput.type === "password"){
        passInput.type = "text";
        confirmpassInput.type = "text";
    } else {
        passInput.type = "password";
        confirmpassInput.type = "password";
    }
}

function toggle_signup(){
    const loginform = document.querySelector('.login'); // we put the div class name to loginform var
    const signupform = document.querySelector('.signup');// same as this

    /*returns the actual display value currently applied, it can read inline or external file css
      the (signupform) is the variable where we store our signup div class*/
    const signupDisplay = window.getComputedStyle(signupform).display;

    /*checking if our display on our signupform is equal to none which is,
     it is equal to none, so the code inside of the if statement will run*/
    if(signupDisplay === "none"){

        /*after we know that our display is equal to none,
        we set now the signupform display to flex to see or pop up the signupform*/
        signupform.style.display = "flex";

        /*after the signupform appear we will now hide the loginform by putting display to none*/
        loginform.style.display = "none";
        
    } else {
        /*if now the signupdisplay is not none (could be flex or block),
        we will now hide it and show login form */
        signupform.style.display = "none";
        loginform.style.display = "flex";
    }
}

function pass_strength(password){
    const strengthB = document.getElementById('strengthBar');
    const strengthIndicator = document.querySelector('.strength-indicator');
    let strength = 0;

    // Show strength indicator when there's input
    if(password.length > 0) {
        strengthIndicator.style.opacity = '1';
    } else {
        strengthIndicator.style.opacity = '0';
    }

    if(password.length >= 8) strength++;
    if(password.match(/[a-z]/)) strength++;
    if(password.match(/[A-Z]/)) strength++;
    if(password.match(/[0-9]/)) strength++;
    //^a-zA-Z0-9 = match the password if the user put anything except a-z,A-Z,0-9
    //so you can put any signs or symbols
    if(password.match(/[^a-zA-Z0-9]/)) strength++;

    //It's a cleanup step to prevent old classes from interfering with new ones
    strengthB.className = 'strength-bar'; 
  
    switch(strength){
        case 1:
        case 2: 
            strengthB.classList.add('strength-weak');
            break;
        case 3: 
            strengthB.classList.add('strength-medium');
            break;
        case 4: 
            strengthB.classList.add('strength-strong');
            break;
        case 5:
        case 6: 
            strengthB.classList.add('strength-very-strong');
            break;
    }
}