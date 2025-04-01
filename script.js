document.addEventListener("DOMContentLoaded", function () {
    document.getElementById('formularContact').addEventListener('submit', function(event) {
        event.preventDefault();

        var nume = document.gestElementById('nume').value.trim();
        var email = document.getElementById('email').value.trim();
        var mesaj = document.getElementById('mesaj').value.trim();

        if (nume === "" || email === "" || mesaj === "") {
            alert("Te rugăm să completezi toate câmpurile!");
            return;
        }

        var raspuns = `<h2>Mulțumim pentru mesaj, ${nume}!</h2>
                       <p>Vom răspunde la adresa de email: <strong>${email}</strong></p>
                       <p>Mesajul tău: <em>${mesaj}</em></p>`;

        var raspunsElement = document.getElementById('raspuns');
        raspunsElement.style.display = "block"; // Asigură că apare
        raspunsElement.style.opacity = 0; // Setează inițial la 0
        raspunsElement.innerHTML = raspuns;

        setTimeout(() => {
            raspunsElement.style.transition = "opacity 1s ease-in-out";
            raspunsElement.style.opacity = 1; // Efect de fade-in
        }, 100);
    });
});
