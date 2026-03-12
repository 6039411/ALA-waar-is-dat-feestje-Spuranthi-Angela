
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


var dagen = document.querySelectorAll(".day");

dagen.forEach(function(dag) {

    dag.addEventListener("click", function() {

        var dagNummer = this.innerText;

        var vandaag = new Date();
        var jaar = vandaag.getFullYear();
        var maand = vandaag.getMonth() + 1;

        var datum = jaar + "-" + maand + "-" + dagNummer;

        document.getElementById("activity-date").value = datum;

        document.getElementById("selected-date").innerText = "Datum: " + datum;

        document.getElementById("day-popup").style.display = "block";

    });

});