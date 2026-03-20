import Activity from "./activityClass.js";
import Calendar from "./calendarClass.js";

// variebalen
const calendar = new Calendar();
const form = document.getElementById("activity-form");
const popup = document.getElementById("day-popup");
const closeBtn = document.querySelector("#day-popup .close-popup");
const selectedDate = document.getElementById("selected-date");
const activityDateInput = document.getElementById("activity-date");
const days = document.querySelectorAll(".day");
const closeDetail = document.getElementById("close-detail");
const currentMonth = document.getElementById("current-month");
const dropdown = document.getElementById("month-dropdown");


// activiteit opslaan
form.addEventListener("submit", function(e) {
    e.preventDefault();

    const name = document.getElementById("activity-name").value;
    const type = document.getElementById("activity-type").value;
    const time = document.getElementById("activity-time").value;
    const status = document.getElementById("activity-status").value;
    const description = document.getElementById("activity-description").value;
    const date = document.getElementById("activity-date").value;

    console.log("Formulier data:", { name, type, time, status, description, date });

    const formData = new FormData(form);
    console.log("Fetch wordt gestart...");

    fetch("Actions/saveActiviteit.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.text())
    .then(result => {
        console.log("Server antwoord:", result);
        if (result === "succes") {
            const activity = new Activity(name, type, time, status, description, date);
            calendar.addActivity(activity);
            popup.classList.remove("active");
            form.reset();
        } else {
            alert("Opslaan mislukt: " + result);
        }
    })
    .catch(error => {
        console.error("Fetch fout:", error);
        alert("Er is een fout opgetreden: " + error);
    });
});


// activiteit detail close
closeDetail.addEventListener("click", () => {
    document.getElementById("activity-detail").classList.remove("active");
});


// maand dropdown
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
days.forEach(dag => {
    dag.addEventListener("click", () => {
        const dagNummer = dag.innerText.trim();
        const vandaag = new Date();
        const jaar = vandaag.getFullYear();
        const maand = vandaag.getMonth() + 1;

        const maandFormatted = String(maand).padStart(2, "0");
        const dagFormatted = String(dagNummer).padStart(2, "0");
        const datum = `${jaar}-${maandFormatted}-${dagFormatted}`;

        activityDateInput.value = datum;
        selectedDate.innerText = "Datum: " + datum;
        popup.classList.add("active");
    });
});


// popup close
closeBtn.addEventListener("click", () => {
    popup.classList.remove("active");
});