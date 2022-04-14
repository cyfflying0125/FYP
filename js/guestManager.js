var isAddNewService = false;
var isAddNewProcessional = false;
function addNewService() {
  if(!isAddNewService) {
    document.getElementById('newService').style.display = "inline-block";
    isAddNewService = true;
    document.getElementById('serviceIcon').src = "icon/minus.png";
  } else {
    document.getElementById('newService').style.display = "none";
    isAddNewService = false;
    document.getElementById('serviceIcon').src = "icon/add.png";
  }
}
function addNewProcessional() {
  if (!isAddNewProcessional) {
    document.getElementById('newProcessional').style.display = "";
    isAddNewProcessional = true;
    document.getElementById('processionalIcon').src = "icon/minus.png";
  } else {
    document.getElementById('newProcessional').style.display = "none";
    isAddNewProcessional = false;
    document.getElementById('processionalIcon').src = "icon/add.png";
  }

}
function openEdit(id,name,category,role,tableNo,confirmation,remarks) {
  document.getElementById('overlay').style.display = "block";
  document.getElementById('guestID').value = id;
  document.getElementById('name').value = name;
  document.getElementById('category').value = category;
  document.getElementById('tableNo').value = tableNo;
  document.getElementById('confirmation').value = confirmation;
  document.getElementById('remarks').value = remarks;
  document.getElementById('role').value = role;
  var select;
  if(role == "Processional") select = "p";
  if(role == "Service") select = "s";
  if(role == "Guest") select = "g";
  document.getElementById(select).selected = true;

}
function closeOverlay() {
  document.getElementById('overlay').style.display = "none";
}
