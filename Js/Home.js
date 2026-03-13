
//pop up registeren activiteit
import Activity from "./activityClass.js";
import Calendar from "./calendarClass.js";

const calendar = new Calendar();
const form = document.getElementById("activity-form");

form.addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch("Models/activiteitConn.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        if (result === "succes") {
            popup.classList.remove("active");
            form.reset();
            alert("Activiteit opgeslagen!");
        } else {
            alert("Opslaan mislukt, probeer opnieuw.");
        }
    })
    .catch(error => {
        console.error("Fout:", error);
        alert("Er is een fout opgetreden.");
    });
});




// maand dropdown selector
const currentMonth = document.getElementById("current-month");
const dropdown = document.getElementById("month-dropdown");

currentMonth.addEventListener("click", () => {
    dropdown.style.display =
        dropdown.style.display === "block" ? "none" : "block";
});

dropdown.querySelectorAll("article").forEach(item => {
    item.addEventListener("click", () => {
        currentMonth.textContent = item.dataset.month;
        dropdown.style.display = "none";
    });
});
 
document.addEventListener("click", (e) => {
    if (!e.target.closest(".month-selector")) {
        dropdown.style.display = "none";
    }
});








// pop up


const dagen = document.querySelectorAll(".day");
const popup = document.getElementById("day-popup");
const closeBtn = document.querySelector("#day-popup .close-popup");
const selectedDate = document.getElementById("selected-date");
const activityDateInput = document.getElementById("activity-date");

dagen.forEach(dag => {
    dag.addEventListener("click", () => {
        const dagNummer = dag.innerText;
        const vandaag = new Date();
        const jaar = vandaag.getFullYear();
        const maand = vandaag.getMonth() + 1;

        // Zet maand en dag altijd op 2 cijfers
        const maandFormatted = String(maand).padStart(2, "0");
        const dagFormatted = String(dagNummer).padStart(2, "0");

        const datum = `${jaar}-${maandFormatted}-${dagFormatted}`;

        // Vul hidden input
        activityDateInput.value = datum;

        // Toon datum in popup
        selectedDate.innerText = "Datum: " + datum;

        // Open popup
        popup.classList.add("active");
    });
});

// Sluit popup
closeBtn.addEventListener("click", () => {
    popup.classList.remove("active");
});