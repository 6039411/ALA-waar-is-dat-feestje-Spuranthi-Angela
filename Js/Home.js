import Activity from "./activityClass.js";
import Calendar from "./calendarClass.js";

// Extended class
class SpecialActivity extends Activity {
    constructor(name, type, time, status, description, date, location) {
        super(name, type, time, status, description, date); // erf alles van Activity
        this.location = location; // extra veld
    }

    // methode die parent info uitbreidt
    info() {
    return `${this.name} (${this.type}) op ${this.date} bij ${this.location}`;
    }      

    // static method
    static description() {
        return "SpecialActivity class maakt activiteiten met extra locatie";
    }
} 


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
let selectedMonth = new Date().getMonth() + 1;


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
            // gewone activiteit
            const activity = new Activity(name, type, time, status, description, date);
            calendar.addActivity(activity);

            // speciale activiteit met extra locatie
            const special = new SpecialActivity(name, type, time, status, description, date, "Park");
            calendar.addActivity(special);

            // gebruik static method
            console.log(SpecialActivity.description());

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

dropdown.querySelectorAll("article").forEach((item, index) => {
    item.addEventListener("click", () => {
        currentMonth.textContent = item.dataset.month;

        selectedMonth = index + 1;

        console.log("Nieuwe maand:", selectedMonth); // check

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
        const maand = selectedMonth;
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


// filteren

function initFilter() {
    const searchInput = document.getElementById("search-input");

    searchInput.addEventListener("input", function() {
        const zoekTerm = this.value.toLowerCase();

        // container maken of ophalen
        let container = document.getElementById("zoek-resultaten");
        if (!container) {
            container = document.createElement("article");
            container.id = "zoek-resultaten";
            container.style.border = "1px solid #ccc";
            container.style.padding = "5px";
            container.style.marginTop = "5px";
            container.style.maxHeight = "200px";
            container.style.overflowY = "auto";
            container.style.backgroundColor = "#fff";
            document.querySelector(".filters").appendChild(container);
        }

        // leeg maken als zoekveld leeg is
        if (zoekTerm === "") {
            container.innerHTML = "";
            return;
        }

        // filter activiteiten
        const resultaten = calendar.activities.filter(activity =>
            activity.name.toLowerCase().includes(zoekTerm)
        );

        // toon resultaten
        container.innerHTML = "";
        resultaten.forEach(activity => {
            const item = document.createElement("article");
            item.textContent = activity.name;
            item.style.cursor = "pointer";
            item.style.padding = "3px 5px";
            item.addEventListener("click", () => {
                calendar.openDetail(activity);
            });
            container.appendChild(item);
        });
    });
}

// laad activiteiten en start filter
function laadActiviteitenEnFilter() {
    fetch("Models/getActiviteiten.php")
        .then(res => res.json())
        .then(data => {
            data.forEach(item => {
                const activity = new Activity(
                    item.Naam,
                    item.Type,
                    item.Tijd,
                    "Gepland",
                    item.Beschrijving,
                    item.Datum
                );
                calendar.addActivity(activity);
            });

            // pas nu filter initialiseren
            initFilter();
        })
        .catch(err => console.error("Fout bij laden activiteiten:", err));
}

// start alles
laadActiviteitenEnFilter();