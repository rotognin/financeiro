// JavaScript Document
$("button[type='submit']").click(function(e){
	e.preventDefault();

	var uid = $('#login').val();
	var pwd = $('#senha').val();

   if (uid.length < 3)
   {
      $('#retorno').html('<p>Digite o login.</p>');
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