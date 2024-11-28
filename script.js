function toggleDescricao(element, event) {
    event.stopPropagation(); // Evita que outros eventos sejam acionados
    const fullText = element.getAttribute('data-full-text');
    const card = element.closest('.card'); // Obtém o card pai

    if (element.innerHTML.endsWith("...")) {
        element.innerHTML = fullText; // Mostra o texto completo
        card.style.height = "auto"; // Permite que o card cresça
    } else {
        element.innerHTML = fullText.substring(0, 30) + "..."; // Retorna ao texto truncado
        card.style.height = ""; // Remove restrições de altura
    }
}

// Função para verificar se o tipo de imagem é válido antes de enviar o formulário
function validarFormulario(event) {
    var foto = document.forms["formEdit"]["foto"].files[0];
    var tiposPermitidos = ['image/jpg', 'image/jpeg', 'image/png', 'image/webp', 'image/jfif', 'image/tiff', 'image/psd', 'image/bmp'];

    if (foto) {
        var tipoArquivo = foto.type;

        // Verifique qual é o tipo do arquivo
        console.log("Tipo de arquivo: " + tipoArquivo);

        // Se o tipo do arquivo não for permitido, exibe um alerta e impede o envio do formulário
        if (!tiposPermitidos.includes(tipoArquivo)) {
            alert('Tipo de imagem inválido. Por favor, envie uma imagem válida (JPG, PNG, WebP, etc.).');
            event.preventDefault(); // Impede o envio do formulário
            return false; // Evita o submit
        }
    }

    // Se tudo estiver correto, o formulário será enviado
    alert('Resíduo editado com sucesso!');
    return true;
}
