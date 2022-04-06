function sum(className) {
  var sum = 0.00;
  document.querySelectorAll(className).forEach((item) => {
    if(!isNaN(item.innerHTML)) sum += parseFloat(item.innerHTML);
  });
  return sum;
}

function calculateE(i) {
  var idE = "E" + i;
  var idD = "D" + i;
  var idA = "A" + i;
  var valueE = parseFloat(document.getElementById(idE).innerHTML); //input value in float
  var displayE;
  var displayEtotal;
  var displayD;
  var displayDtotal;

  if (!isNaN(valueE) && valueE > 0 ) {
    displayE = valueE.toFixed(2); //Set display in 2dp
    var valueA = parseFloat(document.getElementById(idA).innerHTML);//get column A value
    displayD = (valueE - valueA).toFixed(2); //calculate difference of the row
    displayEtotal = sum('.estimate').toFixed(2);//display for estimate total
    displayDtotal = (displayEtotal - (document.getElementById("totalA").innerHTML)).toFixed(2);
  } else {
    displayE = null;
    displayD = null;
    displayEtotal = sum('.estimate').toFixed(2);//display for estimate total
    displayDtotal = (displayEtotal - (document.getElementById("totalA").innerHTML)).toFixed(2);
    alert("Please enter a number > $0.00.");
  }

  document.getElementById("totalD").innerHTML = displayDtotal;
  document.getElementById("totalE").innerHTML = displayEtotal;
  document.getElementById(idE).innerHTML = displayE;
  document.getElementById(idD).innerHTML = displayD;

}


function calculateA(i) {
  var idE = "E" + i;
  var idD = "D" + i;
  var idA = "A" + i;
  var valueA = parseFloat(document.getElementById(idA).innerHTML); //input value in float
  var displayA;
  var displayAtotal;
  var displayD;
  var displayDtotal;

  if (!isNaN(valueA) && valueA > 0 ) {
    displayA = valueA.toFixed(2); //Set display in 2dp
    var valueE = parseFloat(document.getElementById(idE).innerHTML);//get column A value
    displayD = (valueE - valueA).toFixed(2); //calculate difference of the row
    displayAtotal = sum('.actual').toFixed(2);//display for estimate total
    displayDtotal = ((document.getElementById("totalE").innerHTML)-displayAtotal).toFixed(2);
  } else {
    displayA = null;
    displayD = null;
    displayAtotal = sum('.actual').toFixed(2);//display for estimate total
    displayDtotal = ((document.getElementById("totalE").innerHTML)-displayAtotal).toFixed(2);
    alert("Please enter a number > $0.00.");
  }

  document.getElementById("totalD").innerHTML = displayDtotal;
  document.getElementById("totalA").innerHTML = displayAtotal;
  document.getElementById(idA).innerHTML = displayA;
  document.getElementById(idD).innerHTML = displayD;

}

var editArray = [];

function insertArray(header,id,idX) {
  var subcategory = header + "";
  var itemID = id;
  var value = document.getElementById(idX).innerHTML + "";
  var innerArray = [id, subcategory, value];
  editArray.push(innerArray);
  console.log(editArray);
  /*
  for (let i = 0; i < editArray.length; i++) {
    if (id == editArray[i][0] && subcategory == editArray[i][1]){
      editArray[i][2] = value;
      console.log(editArray);
      console.log('x');
    } else {


    }
  }*/
}

$(document).ready(function(){
  $("#save").click(function(e){
    e.preventDefault();
    console.log(editArray);
    $.post('update.php',   // url
  			   { editArray: editArray, page:'budget' }, // data to be submit
  			   function(data, status, jqXHR) {// success callback
  						$('p').append(data);

  				}).done(function() { alert('Request done!');

        })
  				  .fail(function(jqxhr, settings, ex) { alert('failed, ' + ex); });

  });
});
