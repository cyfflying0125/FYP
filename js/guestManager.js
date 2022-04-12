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
    
  }

}
