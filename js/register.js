var password = document.getElementById("registerPassword")
  , confirm_password = document.getElementById("ConfirmPassword");

function validatePassword(){
  if(password.value != confirm_password.value) {
    confirm_password.setCustomValidity("Les mots de passe ne corespondent pas");
  } else {
    confirm_password.setCustomValidity('');
  }
}

password.onchange = validatePassword;
confirm_password.onkeyup = validatePassword;


let roleDiv = document.getElementById("role");
let selectRole = document.getElementById("selectRole");

let groupementDiv = document.getElementById("groupement");
let selectGroupement = document.getElementById("selectGroupement");

let courseDiv = document.getElementById("course");
let selectCourse = document.getElementById("selectCourse");

let promoDiv = document.getElementById("promotion");
let selectPromo = document.getElementById("selectPromotion");

groupementDiv.hidden = true;
courseDiv.hidden = true;
promoDiv.hidden = true;

if (selectRole){
selectRole.addEventListener('change', ()=>{
  if(selectRole.value === "Student") {
     promoDiv.hidden = false;
      groupementDiv.hidden = true;
      courseDiv.hidden = true;
  } 
  
  if (selectRole.value === "Instructeur") {
      groupementDiv.hidden = false;
      courseDiv.hidden = true;
      promoDiv.hidden = true;
  } 
  
  if (selectRole.value === "Pilote") {
    groupementDiv.hidden = true;
    courseDiv.hidden = false;
    promoDiv.hidden = true;
  }
});}

