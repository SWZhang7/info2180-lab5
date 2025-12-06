window.onload = function () {
  const lookupCountryBtn = document.getElementById("lookup");
  const lookupCitiesBtn = document.getElementById("lookup-cities");
  const countryInput = document.getElementById("country");
  const resultDiv = document.getElementById("result");

  function fetchData(mode) {
    const country = countryInput.value.trim();
    let url = "world.php?country=" + encodeURIComponent(country);

    if (mode === "cities") {
      url += "&lookup=cities";
    }

    fetch(url)
      .then((response) => response.text())
      .then((data) => {
        resultDiv.innerHTML = data;
      })
      .catch((error) => {
        resultDiv.innerHTML = "<p>Error: " + error + "</p>";
      });
  }

  
  lookupCountryBtn.addEventListener("click", function (e) {
    e.preventDefault();
    fetchData("country");
  });

  
  lookupCitiesBtn.addEventListener("click", function (e) {
    e.preventDefault();
    fetchData("cities");
  });
};
