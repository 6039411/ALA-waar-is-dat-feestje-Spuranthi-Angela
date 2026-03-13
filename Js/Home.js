
// maand dropdown selector
//pop up registeren activiteit
import Activity from "./activityClass.js";
import Calendar from "./calendarClass.js";

const calendar = new Calendar();
const form = document.getElementById("activity-form");

form.addEventListener("submit", function(e) {

    e.preventDefault();

    const name = document.getElementById("activity-name").value;
    const type = document.getElementById("activity-type").value;
    const time = document.getElementById("activity-time").value;
    const status = document.getElementById("activity-status").value;
    const description = document.getElementById("activity-description").value;

    const dateText = document.getElementById("selected-date").textContent;
    const date = dateText.match(/\d+/)[0];

    const activity = new Activity(
        name,
        type,
        time,
        status,
        description,
        date
    );

    calendar.addActivity(activity);

    popup.classList.remove("active");

    form.reset();

});

const closeDetail = document.getElementById("close-detail");

closeDetail.addEventListener("click", () => {

    document.getElementById("activity-detail").classList.remove("active");

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


const days = document.querySelectorAll(".day");
const popup = document.getElementById("day-popup");
const closeBtn = document.querySelector("#day-popup .close-popup");
const selectedDate = document.getElementById("selected-date");

days.forEach(day => {
  day.addEventListener("click", () => {
    const date = day.textContent.trim();
    selectedDate.textContent = "Datum: " + date + " februari 2026";
    popup.classList.add("active");
  });
});

closeBtn.addEventListener("click", () => {
  popup.classList.remove("active");
});