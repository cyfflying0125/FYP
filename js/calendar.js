
const date = new Date();

const renderCalendar = () => {
  date.setDate(1);

  const monthDays = document.querySelector(".days");

  const lastDay = new Date(
    date.getFullYear(),
    date.getMonth() + 1,
    0
  ).getDate(); //current year, current month, last day

  const prevLastDay = new Date(
    date.getFullYear(),
    date.getMonth(),
    0
  ).getDate(); //current year, previous month, last day


  const firstDayIndex = date.getDay();

  const lastDayIndex = new Date(
    date.getFullYear(),
    date.getMonth() + 1,
    0
  ).getDay();

  const nextDays = 7 - lastDayIndex - 1;

  const months = [
    "January",
    "February",
    "March",
    "April",
    "May",
    "June",
    "July",
    "August",
    "September",
    "October",
    "November",
    "December",
  ];

  document.querySelector(".date h1").innerHTML = months[date.getMonth()] + " " + date.getFullYear();


  let days = "";


  for (let x = firstDayIndex; x > 0; x--) {
    days += `<div class="prev-date">${prevLastDay - x + 1}</div>`;
  }

  for (let i = 1; i <= lastDay; i++) {
    if (
      i === new Date().getDate() &&
      date.getMonth() === new Date().getMonth()&&
      date.getYear() === new Date().getYear()
    ) {
      days += `<div class="today">${i}</div>`;
    } else {
      days += `<div class="current-date">${i}</div>`;
    }
  }

  for (let j = 1; j <= nextDays; j++) {
    days += `<div class="next-date">${j}</div>`;
  }
  monthDays.innerHTML = days;
};



document.querySelector(".prev").addEventListener("click", () => {
  date.setMonth(date.getMonth() - 1);
  renderCalendar();
  addEL();
});


document.querySelector(".next").addEventListener("click", () => {
  date.setMonth(date.getMonth() + 1);
  renderCalendar();
  addEL();
});

renderCalendar();

function updateDate(date) {
  var xhttp = new XMLHttpRequest();
  xhttp.onload = function() {
    document.getElementById("event").innerHTML = this.responseText;
  }
  xhttp.open("GET", "event.php?date="+date);
  xhttp.send();
}

function addEL() {
  document.querySelectorAll('.current-date').forEach(item => {
    item.addEventListener('click', event => {
      if (prevSelected != null) prevSelected.style.backgroundColor = '#E7E3E0';//reset previous

      var dateSelected = event.target.innerHTML;
      var monthYear = document.querySelector(".date h1").innerHTML;
      var date = dateSelected + " " + monthYear;
      document.getElementById('currentDate').value = date;//change date in the form
      event.target.style.backgroundColor = 'white';//highlight current date
      prevSelected = event.target;
      console.log('scheduler js called');
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
}
