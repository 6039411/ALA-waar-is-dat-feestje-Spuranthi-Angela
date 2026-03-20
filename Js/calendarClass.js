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
            activityElement.innerHTML = `${activity.name}<br>
                                         ${activity.time}`;
            activityElement.addEventListener("click", (e) => {
                e.stopPropagation();
                this.openDetail(activity);
            });

            day.appendChild(activityElement);
        }
    });
}

    openDetail(activity){
        document.getElementById("detail-name").textContent = activity.name;
        document.getElementById("detail-type").textContent = activity.type;
        document.getElementById("detail-time").textContent = activity.time;
        document.getElementById("detail-status").textContent = activity.status;
        document.getElementById("detail-description").textContent = activity.description;

    const weerDiv = document.getElementById("weer");
    const type = activity.type.trim().toLowerCase();

    if (type === "buiten") {
        weerDiv.style.display = "block";
        laadWeer(); 
    } else {
        weerDiv.style.display = "none";
        weerDiv.innerHTML = "";
    }

        document.getElementById("activity-detail").classList.add("active");

    }

}