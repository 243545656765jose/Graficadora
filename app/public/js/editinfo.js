$(document).ready(function() {
    // Animación para el mensaje de alerta
    $(".alert").delay(3000).slideUp(300);

    // Validación adicional para confirmar contraseñas en el frontend
    $("form").on("submit", function(e) {
        const newPassword = $("#new_password").val();
        const confirmPassword = $("#confirm_password").val();
        
        if (newPassword !== confirmPassword) {
            e.preventDefault();
            alert("La nueva contraseña y la confirmación deben coincidir.");
        }
    });
});
