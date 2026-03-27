import Activity from "./activityClass.js";
import Calendar from "./calendarClass.js";

class SpecialActivity extends Activity {
    constructor(name, type, time, status, description, date, id, location) {
        super(name, type, time, status, description, date, id);
        this.location = location;
    }

    info() {
        return `${this.name} (${this.type}) op ${this.date} bij ${this.location}`;
    }

    static description() {
        return "SpecialActivity class maakt activiteiten met extra locatie";
    }
}

const calendar          = new Calendar();
const form              = document.getElementById("activity-form");
const popup             = document.getElementById("day-popup");
const closeBtn          = document.querySelector("#day-popup .close-popup");
const selectedDate      = document.getElementById("selected-date");
const activityDateInput = document.getElementById("activity-date");
const days = document.querySelectorAll(".day");
const closeDetail = document.getElementById("close-detail");
const currentMonth = document.getElementById("current-month");
const dropdown = document.getElementById("month-dropdown");
let selectedMonth = new Date().getMonth() + 1;



form.addEventListener("submit", function(e) {
    e.preventDefault();

    const name        = document.getElementById("activity-name").value;
    const type        = document.getElementById("activity-type").value;
    const time        = document.getElementById("activity-time").value;
    const status      = document.getElementById("activity-status").value;
    const description = document.getElementById("activity-description").value;
    const date        = document.getElementById("activity-date").value;

    const formData = new FormData(form);
    console.log("Formulier data:", { name, type, time, status, description, date });

    fetch("Actions/saveActiviteit.php", {
        method: "POST",
        body: formData
    })
    .then(response => response.json())
    .then(result => {
        console.log("Server antwoord:", result);
        if (result.status === "succes") {
            const activity = new Activity(name, type, time, status, description, date, result.id);
            calendar.addActivity(activity);

            const special = new SpecialActivity(name, type, time, status, description, date, result.id, "Park");
            console.log(special.info());
            console.log(SpecialActivity.description());

            popup.classList.remove("active");
            form.reset();
        } else {
            alert("Opslaan mislukt.");
        }
    })
    .catch(error => {
        console.error("Fetch fout:", error);
        alert("Er is een fout opgetreden: " + error);
    });
});

document.getElementById("btn-aanmelden").addEventListener("click", function() {
    const activiteitId = document.getElementById("activity-detail").dataset.activiteitId;
    const actie        = this.dataset.actie;
    const berichtEl    = document.getElementById("aanmeld-bericht");

    if (!activiteitId) {
        berichtEl.textContent = "Geen activiteit ID — sla de activiteit eerst op.";
        return;
    }

    const formData = new FormData();
    formData.append("activiteit_id", activiteitId);
    formData.append("actie", actie);

    fetch("Actions/aanmelden.php", { method: "POST", body: formData })
        .then(r => r.json())
        .then(data => {
            berichtEl.textContent = data.bericht;
            if (data.succes) {
                calendar.updateAanmeldKnop(actie === "aanmelden");
            }
        });
});


// uitnodiging versturen via mailhog
document.getElementById("btn-uitnodiging").addEventListener("click", function() {
    const activiteitId = document.getElementById("activity-detail").dataset.activiteitId;
    const email        = document.getElementById("uitnodiging-email").value.trim();
    const berichtEl    = document.getElementById("uitnodiging-bericht");

    if (!email) {
        berichtEl.textContent = "Vul een e-mailadres in.";
        return;
    }
    if (!activiteitId) {
        berichtEl.textContent = "Geen activiteit ID beschikbaar.";
        return;
    }

    const formData = new FormData();
    formData.append("activiteit_id", activiteitId);
    formData.append("email", email);

    fetch("Actions/verstuurUitnodiging.php", { method: "POST", body: formData })
        .then(r => r.json())
        .then(data => {
            berichtEl.textContent = data.bericht;
            if (data.succes) {
                document.getElementById("uitnodiging-email").value = "";
            }
        });
});

// --

closeDetail.addEventListener("click", () => {
    document.getElementById("activity-detail").classList.remove("active");
});


currentMonth.addEventListener("click", () => {
    dropdown.style.display = dropdown.style.display === "block" ? "none" : "block";
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


// popup voor elke dag
days.forEach(dag => {
    dag.addEventListener("click", () => {
        const dagNummer = dag.innerText.trim();
        const vandaag = new Date();
        const jaar = vandaag.getFullYear();
        const maand = selectedMonth;
        const maandFormatted = String(maand).padStart(2, "0");
        const dagFormatted   = String(dagNummer).padStart(2, "0");
        const datum          = `${jaar}-${maandFormatted}-${dagFormatted}`;

        activityDateInput.value = datum;
        selectedDate.innerText  = "Datum: " + datum;
        popup.classList.add("active");
    });
});

//--

closeBtn.addEventListener("click", () => {
    popup.classList.remove("active");
});


// filters
function initFilter() {
    const searchInput = document.getElementById("search-input");

    searchInput.addEventListener("input", function() {
        const zoekTerm = this.value.toLowerCase();

        let container = document.getElementById("zoek-resultaten");
        if (!container) {
            container = document.createElement("article");
            container.id                    = "zoek-resultaten";
            container.style.border          = "1px solid #ccc";
            container.style.padding         = "5px";
            container.style.marginTop       = "5px";
            container.style.maxHeight       = "200px";
            container.style.overflowY       = "auto";
            container.style.backgroundColor = "#fff";
            document.querySelector(".filters").appendChild(container);
        }

        if (zoekTerm === "") {
            container.innerHTML = "";
            return;
        }

        const resultaten = calendar.activities.filter(activity =>
            activity.name.toLowerCase().includes(zoekTerm)
        );

        container.innerHTML = "";
        resultaten.forEach(activity => {
            const item         = document.createElement("article");
            item.textContent   = activity.name;
            item.style.cursor  = "pointer";
            item.style.padding = "3px 5px";
            item.addEventListener("click", () => {
                calendar.openDetail(activity);
            });
            container.appendChild(item);
        });
    });
}


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
                    item.Datum,
                    item.id
                );
                calendar.addActivity(activity);
            });

            initFilter();
        })
        .catch(err => console.error("Fout bij laden activiteiten:", err));
}

laadActiviteitenEnFilter();