function formhash(form, password) {
    // Crie um novo elemento de input, o qual será o campo para a senha com hash. 
    var p = document.createElement("input");
 
    // Adicione um novo elemento ao nosso formulário. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Cuidado para não deixar que a senha em texto simples não seja enviada. 
    password.value = "";
 
    // Finalmente, envie o formulário. 
    form.submit();
}
 
function regformhash(form, uid, email, password, conf) {
     // Confira se cada campo tem um valor
    if (uid.value == ''         || 
          email.value == ''     || 
          password.value == ''  || 
          conf.value == '') {
 
        alert('You must provide all the requested details. Please try again');
        return false;
    }
 
    // Verifique o nome de usuário
 
    re = /^(?=.*[A-Z]{2})(?=.*[0-9]{6}).{8}$/; 
    if(!re.test(form.login.value)) { 
        alert("O Login deve possuir 2 letras maiusculas,6 números"); 
        form.login.focus();
        return false; 
    }
    
    re = /^[a-zA-ZéúíóáÉÚÍÓÁèùìòàçÇÈÙÌÒÀõãñÕÃÑêûîôâÊÛÎÔÂëÿüïöäËYÜÏÖÄ\-\ \s]+$/; 
    if(!re.test(form.username.value)) { 
        alert("O nome do usuario deve conter apenas letras e espaços"); 
        form.username.focus();
        return false; 
    }
 
    // Confira se a senha é comprida o suficiente (no mínimo, 6 caracteres)
    // A verificação é duplicada abaixo, mas o cuidado extra é para dar mais 
    // orientações específicas ao usuário
    if (password.value.length < 6) {
        alert('Passwords must be at least 6 characters long.  Please try again');
        form.password.focus();
        return false;
    }
 
    // Pelo menos um número, uma letra minúscula e outra maiúscula 
    // Pelo menos 6 caracteres  var re = /(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{6,}/; 
 
    var re = /^(?=.*[A-Z].*[A-Z])(?=.*[a-z].*[a-z])(?=.*[0-9]{4})(?=.*[a-z]{1}).{9}$/; 
    if (!re.test(password.value)) {
        alert('A senha deve conter 2 letras maiusculas, 2 minusculas, 4 números e finalizar com uma letra minuscula. Tente novamente.S');
        return false;
    }
 
    // Verificar se a senha e a confirmação são as mesmas
  if (password.value != conf.value) {
        alert('Sua senha não está igual. Tente novamente');
        form.password.focus();
        return false;
    }
 
    // Crie um novo elemento de input, o qual será o campo para a senha com hash. 
    var p = document.createElement("input");
 
    // Adicione o novo elemento ao nosso formulário. 
    form.appendChild(p);
    p.name = "p";
    p.type = "hidden";
    p.value = hex_sha512(password.value);
 
    // Cuidado para não deixar que a senha em texto simples não seja enviada. 
    password.value = "";
    conf.value = "";
 
    // Finalizando, envie o formulário.  
    form.submit();
    return true;
}