var prevSelected = null;


  document.querySelectorAll('.current-date').forEach(item => {
    item.addEventListener('click', event => {
      if (prevSelected != null) prevSelected.style.backgroundColor = '#E7E3E0';

      var dateSelected = event.target.innerHTML;
      var monthYear = document.querySelector(".date h1").innerHTML;
      document.getElementById('current').innerHTML = dateSelected + " " + monthYear;
      event.target.style.backgroundColor = 'white';
      prevSelected = event.target;
    })
  });

  document.querySelector(".today").addEventListener("click", () => {
    if (prevSelected != null) prevSelected.style.backgroundColor = '#E7E3E0';
    var dateSelected = event.target.innerHTML;
    var monthYear = document.querySelector(".date h1").innerHTML;
    document.getElementById('current').innerHTML = dateSelected + " " + monthYear;
    prevSelected = null;
  });
