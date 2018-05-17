<?php
    use \Psr\Http\Message\ServerRequestInterface as Request;
    use \Psr\Http\Message\ResponseInterface as Response;

    $app = new \Slim\App;

    $app->get('/', function (Request $request, Response $response) {

        $response->getBody()->write("<h1>Página de gestión API REST de la aplicación de Flor</h1>");

    return $response;
    });

/////////////////////////////////////////////////////////////////////////////////////////////////
    //Obtener todos los empleados
    $app->get('/api/empleados', function(Request $request, Response $response) {

    $consulta = 'SELECT * FROM empleados';


    try {
        //Instancio la base de datos
        $db = new db();

        //Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $empleados = $ejecutar->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        //Exportar esto a formato JSON
        echo json_encode($empleados);

    } catch(PDOException $e) {
        echo '{"error": {"texto": ' . $e->getMessage() . '}' ;
    }

    return $response;
});

/////////////////////////////////////////////////////////////////////
//
//Obtener un empleado
    $app->get('/api/empleado/{id}', function (Request $request, Response $response) {

        $id = $request->getAttribute('id');

    $consulta = "SELECT * FROM empleados WHERE id = '$id'";


    try {
        //Instancio la base de datos
        $db = new db();

        //Conexión
        $db = $db->conectar();
        $ejecutar = $db->query($consulta);
        $empleado = $ejecutar->fetchAll(PDO::FETCH_OBJ);

        $db = null;

        //Exportar esto a formato JSON un solo cliente
        echo json_encode($empleado);

    } catch(PDOException $e) {
        echo '{"error": {"texto": ' . $e->getMessage() . '}' ;
    }

    return $response;
});


/////////////////////////////////////////////////////////////////////
//
//Crear un empleado
    $app->post('/api/crear', function (Request $request, Response $response) {

        $id = $request->getParam('id');
        $nombre = $request->getParam('nombre');
        $direccion = $request->getParam('direccion');
        $telefono = $request->getParam('telefono');

    $consulta = "INSERT INTO empleados (id, nombre, direccion, telefono) VALUES (:id, :nombre, :direccion, :telefono)";


    try {
        //Instancio la base de datos
        $db = new db();

        //Conexión
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute();







    } catch(PDOException $e) {
        echo '<h2>El id es obligatorio o ya existe</h2>' ;
    }

    return $response;
});


/////////////////////////////////////////////////////////////////////
//
//Actualizar un empleado
    $app->put('/api/actualizar/{id}', function (Request $request, Response $response) {

        $id = $request->getAttribute('id');

        $nombre     = $request->getParam('nombre');
        $direccion  = $request->getParam('direccion');
        $telefono   = $request->getParam('telefono');

    $consulta = "UPDATE empleados SET
                id          = :id,
                nombre      = :nombre,
                direccion   = :direccion,
                telefono    = :telefono
                WHERE id = $id";


    try {
        //Instancio la base de datos
        $db = new db();

        //Conexión
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':direccion', $direccion);
        $stmt->bindParam(':telefono', $telefono);
        $stmt->execute();







    } catch(PDOException $e) {
        echo '{"error": {"texto": ' . $e->getMessage() . '}' ;
    }

    return $response;
});

/////////////////////////////////////////////////////////////////////
//
//Eliminar un empleado
    $app->delete('/api/eliminar/{id}', function (Request $request, Response $response) {

        $id = $request->getAttribute('id');

    $consulta = "DELETE FROM empleados WHERE id = '$id'";


    try {
        //Instancio la base de datos
        $db = new db();

        //Conexión
        $db = $db->conectar();
        $stmt = $db->prepare($consulta);
        $stmt->execute();

        $db = null;





    } catch(PDOException $e) {
        echo '{"error": {"texto": ' . $e->getMessage() . '}' ;
    }

    return $response;
});



 ?>
