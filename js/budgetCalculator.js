function calculateE(i) {
  var idE = "E" + i;
  var valueE = parseFloat(document.getElementById(idE).innerHTML);
  if (!isNaN(valueE)) {
    var idA = "A" + i;
    var idD = "D" + i;

    var valueA = parseFloat(document.getElementById(idA).innerHTML);
    var valueD = valueE - valueA;
    document.getElementById(idD).innerHTML = valueD;
    var newE = 0.00;
    document.querySelectorAll('.estimate').forEach((item) => {
      newE += parseFloat(item.innerHTML);
    });
    document.getElementById("totalE").innerHTML = newE;
    var currentA = document.getElementById("totalA").innerHTML;
    if (currentA == null) currentA = 0;
    document.getElementById("totalD").innerHTML = newE - currentA;
  } else {
    alert("Please enter a number > $0.00.");
    document.getElementById(idE).innerHTML="";
  }

}


function calculateA(i) {
  var idA = "A" + i;
  var valueA = parseFloat(document.getElementById(idA).innerHTML);
  if(!isNaN(valueA)) {
    var idE = "E" + i;
    var idD = "D" + i;
    var valueE = parseFloat(document.getElementById(idE).innerHTML);

    var valueD = valueE - valueA;
    document.getElementById(idD).innerHTML = valueD;
    var newA = 0.00;
    document.querySelectorAll('.actual').forEach((item) => {
      rowA = parseFloat(item.innerHTML);
      if (!isNaN(rowA)) newA += parseFloat(item.innerHTML);
    });
    document.getElementById("totalA").innerHTML = newA;
    var currentE = document.getElementById("totalE").innerHTML;
    if (currentE == null) currentE = 0;
    document.getElementById("totalD").innerHTML = currentE - newA;
  } else {
    alert("Please enter a number > $0.00.");
    document.getElementById(idA).innerHTML="";
  }

}
