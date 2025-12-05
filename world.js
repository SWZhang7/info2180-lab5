window.addEventListener('load', function () {
  const lookupBtn = document.getElementById('lookup');
  const countryInput = document.getElementById('country');
  const resultDiv = document.getElementById('result');

  lookupBtn.addEventListener('click', function () {
    const country = countryInput.value.trim();

    fetch('world.php?country=' + encodeURIComponent(country))
      .then(response => response.text())
      .then(data => {
        resultDiv.innerHTML = data;
      })
      .catch(error => {
        console.error(error);
        resultDiv.innerHTML = 'Error fetching data.';
      });
  });
});
