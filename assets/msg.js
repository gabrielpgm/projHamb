function mensagem(icone,mensagem)
{
    const Toast = Swal.mixin({
        toast: true,
        position: "top-end",
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.onmouseenter = Swal.stopTimer;
          toast.onmouseleave = Swal.resumeTimer;
        }
      });
      Toast.fire({
        icon: icone,
        title: mensagem
      });
}

function logout()
{

  $.ajax({
    url: "../../app/src/access/logout.php",
    type: "GET",
    async: true,
    success: function(data){
        window.location.href = "../login"
    },error: function(jqXHR, textStatus, errorThrown)
    {
        console.error("Erro na requisição AJAX:", textStatus, errorThrown);
        console.error("Resposta do servidor:", jqXHR.responseText);
    }


});

}