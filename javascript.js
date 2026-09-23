const registerbutton=document.getElementById('Registreren')
const loginbutton=document.getElementById('Login')
const registerform=document.getElementById('Registreren')
const loginform=document.getElementById('Login')

registerbutton.addEventListener('click',function(){
    loginform.style.display="none";
    registerform.style.display="block";
})
loginbutton.addEventListener('click',function(){
    loginform.style.display="block";
    registerform.style.display="none";
})