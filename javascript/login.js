const form = document.querySelector(".login form");
const continueBtn = form.querySelector(".button input");
const errorText = form.querySelector(".error-text");

form.addEventListener("submit", (e) => {
    e.preventDefault();
});

continueBtn.addEventListener("click", () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "php/login.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                let data = xhr.responseText.trim(); // Trim any whitespace
                if (data === "success") {
                    location.href = "final/dashboard.html";
                } else {
                    errorText.style.display = "block";
                    errorText.textContent = data;
                }
            }
        }
    };
    let formData = new FormData(form);
    xhr.send(formData);
});
