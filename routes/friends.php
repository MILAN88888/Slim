<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/friends/all', function (Request $request, Response $response,array $args) {
    try{
    $obj = new db();
    $conn = $obj->getConnection();
    $stmt = $conn->prepare(
        "SELECT * FROM `friends`"
    );
    $stmt->execute();
    $result = $stmt->get_result();
    $arr =$result->fetch_all();
    // $arr = array();
    // while ($row = mysqli_fetch_assoc($result)) {
    //     array_push($arr, $row);
    // }
    $obj = null;
    $response->getBody()->write(json_encode($arr));

    return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
}
catch(Exception $e)
{
    $error = array(
        "message"=>$e->getMessage()
    );
}
});
$app->get('/friends/{id}', function (Request $request, Response $response,array $args) {
    $id = $args['id'];
    try{
    $obj = new db();
    $conn = $obj->getConnection();
    $stmt = $conn->prepare(
        "SELECT * FROM `friends` WHERE id = $id"
    );
    $stmt->execute();
    $result = $stmt->get_result();
    $arr =$result->fetch_all();
    // $arr = array();
    // while ($row = mysqli_fetch_assoc($result)) {
    //     array_push($arr, $row);
    // }
    $response->getBody()->write(json_encode($arr));

    return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
}
catch(Exception $e)
{
    $error = array(
        "message"=>$e->getMessage()
    );
}
});
$app->get('/friends/delete/{id}', function (Request $request, Response $response,array $args) {
    $id = $args['id'];
    try{
    $obj = new db();
    $conn = $obj->getConnection();
    $stmt = $conn->prepare(
        "DELETE  FROM `friends` WHERE id = $id"
    );
    
    $result = $stmt->execute(); 
    
    // $arr = array();
    // while ($row = mysqli_fetch_assoc($result)) {
    //     array_push($arr, $row);
    // }
    $response->getBody()->write(json_encode($result));

    return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
}
catch(Exception $e)
{
    $error = array(
        "message"=>$e->getMessage()
    );
}
});
$app->post('/friends/add', function (Request $request, Response $response,array $args) {
    
    $params = $request->getParsedBody();
    $email = $params['email'];
    $display_name = $params['display_name'];
    $phone = $params['phone'];
    $sql = "INSERT INTO friends (email,display_name,phone) VALUES (?,?,?)";
    try{
    $obj = new db();
    $conn = $obj->getConnection();
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss",$email,$display_name,$phone);
    $result = $stmt->execute();
    $response->getBody()->write(json_encode($result));

    return $response
            ->withHeader('content-type','application/json')
            ->withStatus(200);
}
catch(Exception $e)
{
    $error = array(
        "message"=>$e->getMessage()
    );
    print_r($error);

}
});


$app->group('/utils', function () use ($app) {
    $app->get('/date', function ($request, $response) {
        return $response->getBody()->write(date('Y-m-d H:i:s'));
    });
    $app->get('/time', function ($request, $response) {
        return $response->getBody()->write(time());
    });
})->add(function ($request, $response, $next) {
    $response->getBody()->write('It is now ');
    $response = $next($request, $response);
    $response->getBody()->write('. Enjoy!');

    return $response;
});