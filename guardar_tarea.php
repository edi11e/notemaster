<?php
// Conexión a la base de datos (reemplaza los valores con los de tu configuración)
$host = 'sql104.infinityfree.com';
$db   = 'if0_36651357_dbpruebaa';
$user = 'if0_36651357';
$pass = 'S4TfOEdzbZ';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

// Recibir datos del formulario
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $descripcion = $_POST['descripcion'];
    $materia = $_POST['materia'];
    $docente = $_POST['docente'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];

    // Preparar consulta SQL para insertar tarea
    $sql = "INSERT INTO tareas (descripcion, materia, docente, fecha, hora) VALUES (:descripcion, :materia, :docente, :fecha, :hora)";
    $stmt = $pdo->prepare($sql);

    // Ejecutar la consulta
    try {
        $stmt->execute([
            'descripcion' => $descripcion,
            'materia' => $materia,
            'docente' => $docente,
            'fecha' => $fecha,
            'hora' => $hora
        ]);
        echo json_encode(['status' => 'success', 'message' => 'Tarea guardada correctamente']);
    } catch (PDOException $e) {
        echo json_encode(['status' => 'error', 'message' => 'Error al guardar la tarea: ' . $e->getMessage()]);
    }
}
?>
