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

