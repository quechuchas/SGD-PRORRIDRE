<?php
// Conexión a la base de datos
$host = "localhost";
$username = "root";
$password = "";
$database = "gestiondoc";

$conn = new mysqli($host, $username, $password, $database);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Recibir datos del formulario
$tipo_persona = $_POST['tipo_persona'];
$tipo_documento = $_POST['tipo_documento'];
$numero_documento = $_POST['numero_documento'];
$nombres = $_POST['nombres'];
$apellidos = $_POST['apellidos'];
$correo = $_POST['correo'];
$tipo_tramite = $_POST['tipo_tramite'];
$asunto = $_POST['asunto'];

// Procesar archivo
$archivo = $_FILES['archivo'];
$archivo_nombre = $archivo['name'];
$archivo_tmp = $archivo['tmp_name'];
$archivo_destino = "uploads/" . $archivo_nombre;

// Mover archivo a la carpeta de destino
if (move_uploaded_file($archivo_tmp, $archivo_destino)) {
    // Insertar datos en la base de datos
    $sql = "INSERT INTO tramites (tipo_persona, tipo_documento, numero_documento, nombres, apellidos, correo, tipo_tramite, asunto, archivo)
            VALUES ('$tipo_persona', '$tipo_documento', '$numero_documento', '$nombres', '$apellidos', '$correo', '$tipo_tramite', '$asunto', '$archivo_nombre')";

    if ($conn->query($sql) === TRUE) {
        echo "Trámite registrado exitosamente.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "Error al subir el archivo.";
}

// Cerrar conexión
$conn->close();
?>