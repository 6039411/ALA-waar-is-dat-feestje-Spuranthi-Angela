fetch("https://weerlive.nl/api/weerlive_api_v2.php?key=24a0a9da10&locatie=Leiden")
.then(res => {
    if (!res.ok) {
        throw new Error("Netwerk fout");
    }
    return res.json();
})
.then(data => {

    const current = data.liveweer[0];

    const temp = current.temp;
    const plaats = current.plaats;
    const weer = current.samenv.toLowerCase();

    let icon = "";

    if (weer.includes("zon")) {
        icon = "☀️";
    } else if (weer.includes("licht bewolkt")) {
        icon = "🌤️";
    } else if (weer.includes("bewolkt")) {
        icon = "☁️";
    } else if (weer.includes("regen")) {
        icon = "🌧️";
    } else {
        icon = "🌡️";
    }   

    document.getElementById("weer").innerHTML =
    `
    <h2>${plaats}</h2>
    <article class="weer-main">
        <span class="icon">${icon}</span>
        <span class="temp">${temp}°C</span>
    </article>
    <p class="beschrijving">${weer}</p>
    `;
})
.catch(error => {
    console.error("Er ging iets mis:", error);
    document.getElementById("weer").innerHTML = "Kan weer niet laden";
});