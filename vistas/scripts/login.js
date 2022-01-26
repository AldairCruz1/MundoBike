/*const inputs = document.querySelectorAll(".input");

function addcl(){
	let parent = this.parentNode.parentNode;
	parent.classList.add("focus");
}

function remcl(){
	let parent = this.parentNode.parentNode;
	if(this.value == ""){
		parent.classList.remove("focus");
	}
}


inputs.forEach(input => {
	input.addEventListener("focus", addcl);
	input.addEventListener("blur", remcl);
});*/


$("#frmAcceso").on("submit", function(e) {
  e.preventDefault();
  login = $("#login").val();
  password = $("#password").val();

  //alert(login+clave);
  $.post(
    "../../controladores/usuario.php?op=verificar",
    { login: login, password: password },
    function(data) {
      if (data != "null") {
        $(location).attr("href", "principal.php");
      } else {
        console.log(login+password);
        alertify.alert("Usuario y/o Password incorrectos");
      }
    }
  );
});