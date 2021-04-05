// Desabilitado

// JavaScript Document
$("button[type='submit']").click(function(e){
	e.preventDefault();

	var nome = $('#login').val();
	var login = $('#login').val();
   var senha = $('#senha').val();
   var senha2 = $('#senha2').val();
   var email = $('#email').val();

   if (nome.length < 5)
   {
      $('#retorno').html('<p>Informar o login.</p>');
      return;
   }

   if (pwd.length < 3)
   {
      $('#retorno').html('<p>Digite a senha.</p>');
      return;
   }

	$.get('/../includes/funcoes/checaLogin.php',{login:uid,senha:pwd}, function(data) {
      if (data != 'ok') {
         $('#resposta').html(data).css({'display':'block','color':'red'});
      } else {
         window.location.href = 'principal.php';
      }
	});
});