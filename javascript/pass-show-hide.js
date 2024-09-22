const passwordField = document.querySelector("input[name='password']"),
      confirmPasswordField = document.querySelector("input[name='confirm_password']"),
      toggleIcons = document.querySelectorAll(".form .field i");

toggleIcons.forEach(icon => {
    icon.onclick = () => {
        if (passwordField.type === "password" && confirmPasswordField.type === "password") {
            passwordField.type = "text";
            confirmPasswordField.type = "text";
            icon.classList.add("active");
        } else {
            passwordField.type = "password";
            confirmPasswordField.type = "password";
            icon.classList.remove("active");
        }
    };
});
