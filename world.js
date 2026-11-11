window.addEventListener("DOMContentLoaded", function () {
    const countryInput = document.getElementById("country");
    const lookupBtn = document.getElementById("lookup");
    const lookupCitiesBtn = document.getElementById("lookup-cities");
    const resultDiv = document.getElementById("result");

    function makeRequest(type) {
        const country = countryInput.value.trim();
        let url = "world.php?country=" + encodeURIComponent(country);

        if (type === "cities") {
            url += "&lookup=cities";
        }

        fetch(url)
            .then(response => response.text())
            .then(data => {
                resultDiv.innerHTML = data;
            })
            .catch(error => {
                console.error(error);
                resultDiv.innerHTML = "An error occurred while fetching data.";
            });
    }

    // Country lookup
    lookupBtn.addEventListener("click", function () {
        makeRequest("countries");
    });

    // Cities lookup
    lookupCitiesBtn.addEventListener("click", function () {
        makeRequest("cities");
    });
});
