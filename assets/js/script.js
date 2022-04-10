// Add your custom scripts here
function hideActionMessage() {
  let close = document.getElementsByClassName("closebtn");
  let messageContainer = document.getElementById("actionMessage");

  setTimeout(function(){ messageContainer.style.display = "none"; }, 4000);

  close[0].onclick = function(){
    messageContainer.style.display = "none";
  }
}

hideActionMessage();
