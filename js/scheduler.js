var prevSelected = null;


  document.querySelectorAll('.current-date').forEach(item => {
    item.addEventListener('click', event => {
      if (prevSelected != null) prevSelected.style.backgroundColor = '#E7E3E0';//reset previous

      var dateSelected = event.target.innerHTML;
      var monthYear = document.querySelector(".date h1").innerHTML;
      var date = dateSelected + " " + monthYear;
      document.getElementById('currentDate').value = date;//change date in the form
      event.target.style.backgroundColor = 'white';//highlight current date
      prevSelected = event.target;
      //update event scheduled
      updateDate(date);
    })
  });

  document.querySelector(".today").addEventListener("click", () => {
    if (prevSelected != null) prevSelected.style.backgroundColor = '#E7E3E0';
    var dateSelected = event.target.innerHTML;
    var monthYear = document.querySelector(".date h1").innerHTML;
    var date = dateSelected + " " + monthYear;
    document.getElementById('currentDate').value = date;
    prevSelected = null;

    //update event scheduled
    updateDate(date);

  });

  function updateDate(date) {
    var xhttp = new XMLHttpRequest();
    xhttp.onload = function() {
      document.getElementById("event").innerHTML = this.responseText;
    }
    xhttp.open("GET", "event.php?date="+date);
    xhttp.send();
  }
