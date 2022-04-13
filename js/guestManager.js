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
function openEdit() {
  document.getElementById('overlay').style.display = "block";

}
function close() {
  document.getElementById('overlay').style.display = "none";
}
