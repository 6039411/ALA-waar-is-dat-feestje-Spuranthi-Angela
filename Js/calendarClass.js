import { laadWeer } from "./WeerApi.js";
export default class Calendar {
    constructor() {
        this.activities = [];
    }

    addActivity(activity) {
        this.activities.push(activity);
        this.renderActivity(activity);
    }

    renderActivity(activity) {
        const days = document.querySelectorAll(".day");

        days.forEach(day => {
            const dagNummer = String(parseInt(activity.date.split("-")[2]));

            if (day.textContent.trim() === dagNummer) {
                const activityElement = document.createElement("article");
                activityElement.classList.add("calendar-activity");
                activityElement.innerHTML = `
                    <span class="activiteit-naam">${activity.name}</span>
                    <span class="activiteit-naam">${activity.time}</span>
                    <span class="activiteit-naam">${activity.type}</span>
                `;
                activityElement.addEventListener("click", (e) => {
                    e.stopPropagation();
                    this.openDetail(activity);
                });

                day.appendChild(activityElement);
            }
        });
    }

    openDetail(activity) {
        document.getElementById("detail-name").textContent        = activity.name;
        document.getElementById("detail-type").textContent        = activity.type;
        document.getElementById("detail-time").textContent        = activity.time;
        document.getElementById("detail-status").textContent      = activity.status;
        document.getElementById("detail-description").textContent = activity.description;

        const detailPopup = document.getElementById("activity-detail");
        detailPopup.dataset.activiteitId = activity.id ?? "";

        const weerDiv = document.getElementById("weer");
        const type    = activity.type.trim().toLowerCase();
        if (type === "buiten") {
            weerDiv.style.display = "block";
            laadWeer();
        } else {
            weerDiv.style.display = "none";
            weerDiv.innerHTML     = "";
        }

        document.getElementById("aanmeld-bericht").textContent     = "";
        document.getElementById("uitnodiging-bericht").textContent = "";
        document.getElementById("uitnodiging-email").value         = "";

        if (activity.id) {
            fetch(`Actions/checkAanmelding.php?activiteit_id=${activity.id}`)
                .then(r => r.json())
                .then(data => this.updateAanmeldKnop(data.aangemeld));
        } else {
            this.updateAanmeldKnop(false);
        }

        detailPopup.classList.add("active");
    }

    updateAanmeldKnop(isAangemeld) {
        const knop = document.getElementById("btn-aanmelden");
        if (isAangemeld) {
            knop.textContent   = "Afmelden";
            knop.dataset.actie = "afmelden";
            knop.classList.add("knop-afmelden");
            knop.classList.remove("knop-aanmelden");
        } else {
            knop.textContent   = "Aanmelden voor deze activiteit";
            knop.dataset.actie = "aanmelden";
            knop.classList.add("knop-aanmelden");
            knop.classList.remove("knop-afmelden");
        }
    }
}