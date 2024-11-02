
    // const hola = document.getElementById("hola");
    // const boton = document.getElementById("boton");
    const form = document.getElementById("form");
    const form2 = document.getElementById("form2");

    function registrar() {

    // hola.classList.add("hola");
    // boton.classList.add("boton");
    form.classList.remove("formi");
    form2.classList.remove("form2i");
    form.classList.add("form");
    form2.classList.add("form2");
        form2.classList.add("form2");
    }

    function iniciar() {

        // hola.classList.add("hola");
        // boton.classList.add("boton");
        form.classList.remove("form");
        form2.classList.remove("form2");
        form.classList.add("formi");
        form2.classList.add("form2i");
        
        }

        
// Verificar si el video ya se mostró anteriormente
var hasShownVideo = getCookie("shownVideo");

if (!hasShownVideo) {
  // Mostrar el video por primera vez
  var videoContainer = document.getElementById("video-container");
  videoContainer.style.display = "flex";

  // Establecer una cookie para marcar que el video se mostró
  setCookie("shownVideo", "true", 0);

  // Desaparecer el video después de 3 segundos
  setTimeout(function() {
    videoContainer.style.display = "none";
  }, 2600);
} else {
  // El video ya se mostró anteriormente, ocultarlo
  var videoContainer = document.getElementById("video-container");
  videoContainer.style.display = "none";
}

// Función para obtener el valor de una cookie
function getCookie(name) {
  var cookieArr = document.cookie.split(";");

  for (var i = 0; i < cookieArr.length; i++) {
    var cookiePair = cookieArr[i].split("=");

    if (name === cookiePair[0].trim()) {
      return decodeURIComponent(cookiePair[1]);
    }
  }

  return null;
}

// Función para establecer una cookie
function setCookie(name, value, days) {
  var expires = "";

  if (days) {
    var date = new Date();
    date.setTime(date.getTime() + days * 24 * 60 * 60 * 1000000);
    expires = "; expires=" + date.toUTCString();
  }

  document.cookie = name + "=" + encodeURIComponent(value) + expires + "; path=/";
}