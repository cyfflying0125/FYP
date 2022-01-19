function dropdown(name) {
  var dropdownContent = document.getElementById(name + 'Dropdown');
  if (dropdownContent.style.display == "block") {
    dropdownContent.style.display = "none";
  } else dropdownContent.style.display = "block";
}
function openDropdown() {
  if (document.getElementById('dropdownAdd').style.display !== "block") {
    document.getElementById('dropdownAdd').style.display = "block";
    document.getElementById('add').style.fontWeight = "bold";

  } else {
    document.getElementById('dropdownAdd').style.display = "none";
    document.getElementById('add').style.fontWeight = "";
  }

}

function addObj(path,r,s) {
  console.log(s);
  document.getElementById('path').value = path;
  document.getElementById('rotation').value = r;
  document.getElementById('scale').value = s;
}
