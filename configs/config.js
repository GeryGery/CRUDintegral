function escapeHtml(unsafe) {
    return unsafe
         .replace('&', "&amp;")
         .replace('<', "&lt;")
         .replace('>', "&gt;")
         .replace('"', "&quot;")
         .replace("'", "&#039;");
}

function isNumeric(value) {
    return /^\d+$/.test(value);
}