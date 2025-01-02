const login_email = document.getElementById("login-email");
const login_password = document.getElementById("login-password");

const labels = document.querySelectorAll(".input-label");

function toggleInputs(){
    labels.forEach(label => {
        const input_id = label.getAttribute("for");
        const input_element = document.getElementById(input_id);

        if(input_element && input_element.value.trim() !== ""){
            label.style.display = "none";
        } else{
            label.style.display = "block";
        }
    })
}

login_email.addEventListener("input",toggleInputs);
login_password.addEventListener("input",toggleInputs);

toggleInputs();