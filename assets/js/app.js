function validateInput(input, regex, errorMessage) {
    const error_span = input.parentElement.querySelector(".error-span");
    if (!regex.test(input.value.trim())) {
        error_span.textContent = errorMessage;
        error_span.style.display = "block";
    } else {
        error_span.textContent = "";
        error_span.style.display = "none";
    }
}

function validateSignupField(input) {
    const name_regex = /^[A-Za-z\s]+$/;
    const email_regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const password_regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

    if (input.id === "signup-name") {
        validateInput(input, name_regex, "Name must contain only letters and spaces.");
    } else if (input.id === "signup-email") {
        validateInput(input, email_regex, "Invalid email format.");
    } else if (input.id === "signup-password") {
        validateInput(input, password_regex, "Password must be at least 8 characters long and include a number.");
    } else if (input.id === "password-confirmed") {
        const signup_password = document.getElementById("signup-password");
        const error_span = input.parentElement.querySelector(".error-span");
        if (signup_password && signup_password.value.trim() !== input.value.trim()) {
            error_span.textContent = "Passwords do not match.";
            error_span.style.display = "block";
        } else {
            error_span.textContent = "";
            error_span.style.display = "none";
        }
    }
}

function toggleInputs() {
    const labels = document.querySelectorAll(".input-label");
    labels.forEach(label => {
        const input_id = label.getAttribute("for");
        const input_element = document.getElementById(input_id);

        if (input_element && input_element.value.trim() !== "") {
            label.style.display = "none";
        } else {
            label.style.display = "block";
        }
    });
}

const login_email = document.getElementById("login-email");
const login_password = document.getElementById("login-password");

if (login_email && login_password) {
    login_email.addEventListener("input", toggleInputs);
    login_password.addEventListener("input", toggleInputs);
}

const signup_fields = document.querySelectorAll("#signup-name, #signup-email, #signup-password, #password-confirmed");
if (signup_fields.length > 0) {
    signup_fields.forEach(field => {
        field.addEventListener("input", toggleInputs);
        field.addEventListener("blur", () => validateSignupField(field));
    });
}

toggleInputs();