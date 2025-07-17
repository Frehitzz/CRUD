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

function passcheckb_manage(){
    const passInput = document.getElementById('reset_pass');
    const confirmpassInput = document.getElementById('reset_conpass');
    
    if(passInput.type === "password"){
        passInput.type = "text";
        confirmpassInput.type = "text";
    } else {
        passInput.type = "password";
        confirmpassInput.type = "password";
    }
}