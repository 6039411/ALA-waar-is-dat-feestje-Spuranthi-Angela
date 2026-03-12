export default class Calendar {
    constructor() {
        this.activities = [];
    }

    addActivity(activity) {
        this.activities.push(activity);
        this.executeActivity(activity);
    }

    executeActivity(activity) {
        
        const days = document.querySelectorAll(".day");

        days.forEach(day => {

            if (day.textContent.trim() === activity.date) {

                const activityElement = document.createElement("div");
                activityElement.classList.add("calendar-activity");

                activityElement.innerHTML =
                    `<strong>${activity.name}</strong><br>
                     ${activity.time}`;

                day.appendChild(activityElement);

            }

        });

    }

}