<?php
require '../vendor/autoload.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

require_once '../model/user.php';
$app = new \Slim\App;
$conn=null;
$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    return new PhpRenderer(__DIR__.'/../view');
};
createconn();
session_start();
function createconn()   
{ 
	global $conn; 
	$dbhost = '140.127.40.40';
	$dbport = '25432';
	$dbuser = 'minlab';
	$dbpasswd = '970314970314';
	$dbname = 'humanresource';
	$dsn = "pgsql:host=".$dbhost.";port=".$dbport.";dbname=".$dbname;
	try
	{
	    
	    $conn = new \PDO($dsn,$dbuser,$dbpasswd);
	    $conn->exec("SET CHARACTER SET utf8");
	    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	    //echo "Connected Successfully";
	}
	catch(PDOException $e)
	{
	    echo "Connection failed: ".$e->getMessage();
	}
}

class ViewMiddleware
{
    public function __invoke($request, $response, $next)
    {
    	if(isset($_SESSION['id']))
        	$response = $next($request, $response);
    	else{
			header("Location: /page/login"); 	
    	}
        return $response;
    }
}
$app->get('/', function (Request $request, Response $response, array $args) {		
	return $response->withRedirect('/page/home', 301);
});
$app->group('/page', function () use ($app) {
	$app->group('', function () use ($app) {
		$app->get('/home', function (Request $request, Response $response, array $args) {		
			return $this->view->render($response, '/index.php', [
		    ]);
		});
		$app->get('/register', function (Request $request, Response $response, array $args) {		
			return $this->view->render($response, '/register.php', [
		    ]);
		});
		$app->get('/table', function (Request $request, Response $response, array $args) {		
			return $this->view->render($response, '/tables.php', [
		    ]);
		});
		$app->get('/modify', function (Request $request, Response $response, array $args) {		
			return $this->view->render($response, '/register.php', [
		    ]);
		});
	})->add( new ViewMiddleware() );
	$app->get('/login', function (Request $request, Response $response, array $args) {	
		session_destroy();
		session_start();
		return $this->view->render($response, '/login.html', [
	    ]);
	});
});

$app->group('/user', function () use ($app) {
	$app->get('/view', function (Request $request, Response $response, array $args) {
		$a = array(
			"abc"=>"abc"
		);		
		var_dump($a);
		return $this->view->render($response, '/404.html', [
	    ]);
	});

	$app->post('/login', function (Request $request, Response $response, array $args) {		
	    $user = new User();
	    $result = $user->login();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
		return $response;
	});
	$app->get('/logout', function (Request $request, Response $response, array $args) {		
		return $response;
 	});
});

$app->group('/staff', function () use ($app) {
	$app->get('/department/get', function (Request $request, Response $response, array $args) {		
	    $staff = new Staff();
	    $result = $staff->getDepartment();	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;	    
	});

	$app->get('/position/get', function (Request $request, Response $response, array $args) {		
	    $staff = new Staff();
	    $result = $staff->getPosition();	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});

	$app->get('/gender/get', function (Request $request, Response $response, array $args) {		
	    $staff = new Staff();
	    $result = $staff->getGender();	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;	    
	});

	$app->get('/marriage/get', function (Request $request, Response $response, array $args) {
	    $staff = new Staff();
	    $result = $staff->getMarriage();	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});

	$app->get('/insuredcompany/get', function (Request $request, Response $response, array $args) {		
	    $staff = new Staff();
	    $result = $staff->getInsuredcompany();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	});

	$app->get('/workStatus/get', function (Request $request, Response $response, array $args) {
	    $staff = new Staff();
	    $result = $staff->getWorkStatus();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});

	$app->get('/staffType/get', function (Request $request, Response $response, array $args) {
	    $staff = new Staff();
	    $result = $staff->getStaffType();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});

	$app->get('/educationCondition/get', function (Request $request, Response $response, array $args) {
	    $staff = new Staff();
	    $result = $staff->getEducationCondition();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});

	$app->get('/staffNum/get', function (Request $request, Response $response, array $args) {
	    $staff = new Staff();
	    $result = $staff->getStaffNum();
	    $ack = array(
			'num'=>$result
		);
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($ack);
		//echo $response['num'];
	    return $response;  
	});

	$app->post('/checkRegister/post', function (Request $request, Response $response, array $args) {
	    $staff = new Staff();
	    $result = $staff->checkRegister();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
		// echo $response;
	    return $response;   
	});

	$app->post('/register/post', function (Request $request, Response $response, array $args) {
	    $staff = new Staff();
	    $ack = $staff->register();  
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($ack);
	    return $response;   

	});

	$app->post('/modify/post', function (Request $request, Response $response, array $args) {
	    $staff = new Staff();
	    $ack = $staff->modify();  
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($ack);
	    return $response;   
	});
});
$app->group('/table', function () use ($app) {
	$app->get('/getTable', function (Request $request, Response $response, array $args) {
		
	    $staff = new Table();
	    $result = $staff->getTable();
	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});
	$app->post('/update/post', function (Request $request, Response $response, array $args) {
		
	    $staff = new Table();
	    $result = $staff->allInfo();
	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);

	    
	    return $response;
	    
	});
	$app->post('/profile/get', function (Request $request, Response $response, array $args) {
		
	    $staff = new Table();
	    $result = $staff->getProfile();
	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);

	    
	    return $response;
	    
	});


	
});

$app->run();

?>