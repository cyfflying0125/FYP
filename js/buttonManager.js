function dropdown(name) {
  var dropdownContent = document.getElementById(name + 'Dropdown');
  if (dropdownContent.style.display == "block") {
    dropdownContent.style.display = "none";
  } else dropdownContent.style.display = "block";
}
function openDropdownAdd() {
  document.getElementById('actionBtn').value = 'add';
  document.getElementById('dropdownAdd').style.top = "260px";
  if (document.getElementById('dropdownAdd').style.display !== "block") {
    document.getElementById('dropdownAdd').style.display = "block";
    document.getElementById('add').style.fontWeight = "bold";

  } else {
    document.getElementById('dropdownAdd').style.display = "none";
    document.getElementById('add').style.fontWeight = "";
  }

}
function openDropdownSwap() {

  document.getElementById('actionBtn').value = 'swap';
  document.getElementById('dropdownAdd').style.top = "380px";
  if (document.getElementById('dropdownAdd').style.display !== "block") {
    document.getElementById('dropdownAdd').style.display = "block";
    document.getElementById('swap').style.fontWeight = "bold";

  } else {
    document.getElementById('dropdownAdd').style.display = "none";
    document.getElementById('swap').style.fontWeight = "";
  }
}

function addObj(path,r,s) {
  console.log(s);
  document.getElementById('path').value = path;
  document.getElementById('rotation').value = r;
  document.getElementById('scale').value = s;
}
