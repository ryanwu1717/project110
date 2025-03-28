<?php
require __DIR__.'/../vendor/autoload.php';
require_once __DIR__.'/../model/user.php';
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Slim\Views\PhpRenderer;

$app = new \Slim\App;
require_once __DIR__.'/../route/management.php';

$container = $app->getContainer();

// Register component on container
$container['view'] = function ($container) {
    return new PhpRenderer(__DIR__.'/../view');
};
$container['db'] = function ($container) {
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
	return $conn;
};
$container['ViewMiddleware'] = function($container) {
    return new ViewMiddleware($container->db);
};
session_start();


class ViewMiddleware
{
	private $conn;
	function __construct($db){
		$this->conn = $db;
	}
    public function __invoke($request, $response, $next)
    {
    	if(isset($_SESSION['id'])){
    		$user = new User($this->conn);
	    	$name = $user->getName();
    		$viewParam = array();
	    	if(count($name)==1){
	    		$viewParam['name'] = $name[0]['staff_name'];
	    	}
    		$request = $request->withAttribute('viewParam', $viewParam);
        	$response = $next($request, $response);
    	}
    	else{
			header("Location: /login"); 	
    	}
        return $response;
    }
}
$app->get('/', function (Request $request, Response $response, array $args) {		
	return $response->withRedirect('/home', 301);
});
$app->group('', function () use ($app) {
	$app->group('', function () use ($app) {
		$app->get('/home', function (Request $request, Response $response, array $args) {	
			$viewParam = $request->getAttribute('viewParam');	
			return $this->view->render($response, '/index.php', $viewParam);
		});
		$app->get('/register', function (Request $request, Response $response, array $args) {	
			$viewParam = $request->getAttribute('viewParam');		
			return $this->view->render($response, '/register.php', $viewParam);
		});
		$app->get('/table', function (Request $request, Response $response, array $args) {	
			$viewParam = $request->getAttribute('viewParam');		
			return $this->view->render($response, '/tables.php', $viewParam);
		});
		$app->get('/modify', function (Request $request, Response $response, array $args) {	
			$viewParam = $request->getAttribute('viewParam');		
			return $this->view->render($response, '/register.php', $viewParam);
		});
	})->add('ViewMiddleware');
	$app->get('/login', function (Request $request, Response $response, array $args) {	
		session_destroy();
		session_start();
		return $this->view->render($response, '/login.php', []);
	});
});

$app->group('/user', function () use ($app) {
	$app->post('/login', function (Request $request, Response $response, array $args) {		
	    $user = new User($this->db);
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
	    $staff = new Staff($this->db);
	    $result = $staff->getDepartment();	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;	    
	});

	$app->get('/position/get', function (Request $request, Response $response, array $args) {		
	    $staff = new Staff($this->db);
	    $result = $staff->getPosition();	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});

	$app->get('/gender/get', function (Request $request, Response $response, array $args) {		
	    $staff = new Staff($this->db);
	    $result = $staff->getGender();	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;	    
	});

	$app->get('/marriage/get', function (Request $request, Response $response, array $args) {
	    $staff = new Staff($this->db);
	    $result = $staff->getMarriage();	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});

	$app->get('/insuredcompany/get', function (Request $request, Response $response, array $args) {		
	    $staff = new Staff($this->db);
	    $result = $staff->getInsuredcompany();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	});

	$app->get('/workStatus/get', function (Request $request, Response $response, array $args) {
	    $staff = new Staff($this->db);
	    $result = $staff->getWorkStatus();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});

	$app->get('/staffType/get', function (Request $request, Response $response, array $args) {
	    $staff = new Staff($this->db);
	    $result = $staff->getStaffType();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});

	$app->get('/educationCondition/get', function (Request $request, Response $response, array $args) {
	    $staff = new Staff($this->db);
	    $result = $staff->getEducationCondition();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});

	$app->get('/staffNum/get', function (Request $request, Response $response, array $args) {
	    $staff = new Staff($this->db);
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
	    $staff = new Staff($this->db);
	    $result = $staff->checkRegister();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
		// echo $response;
	    return $response;   
	});

	$app->post('/register/post', function (Request $request, Response $response, array $args) {
	    $staff = new Staff($this->db);
	    $ack = $staff->register();  
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($ack);
	    return $response;   

	});

	$app->post('/modify/post', function (Request $request, Response $response, array $args) {
	    $staff = new Staff($this->db);
	    $ack = $staff->modify();  
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($ack);
	    return $response;   
	});
});
$app->group('/table', function () use ($app) {
	$app->get('/getTable', function (Request $request, Response $response, array $args) {
		
	    $staff = new Table($this->db);
	    $result = $staff->getTable();
	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	    
	});
	$app->post('/update/post', function (Request $request, Response $response, array $args) {
		
	    $staff = new Table($this->db);
	    $result = $staff->allInfo();
	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);

	    
	    return $response;
	    
	});
	$app->post('/profile/get', function (Request $request, Response $response, array $args) {
		
	    $staff = new Table($this->db);
	    $result = $staff->getProfile();
	    
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);

	    
	    return $response;
	    
	});


	
});

$app->group('/chat', function () use ($app) {
	$app->get('/list', function (Request $request, Response $response, array $args) {
		$chat = new Chat($this->db);
		$result = $chat->getList();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	});
	$app->get('/chatroom', function (Request $request, Response $response, array $args) {
		$chat = new Chat($this->db);
		$result = $chat->getChatroom();
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	});
	$app->post('/chatroom', function (Request $request, Response $response, array $args) {
		$chat = new Chat($this->db);
		$result = $chat->createChatroom($request->getParsedBody());
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	});
	$app->get('/content/{chatID}', function (Request $request, Response $response, array $args) {
		$chat = new Chat($this->db);
		$result = $chat->getChatContent($args['chatID']);
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	});
	$app->patch('/message', function (Request $request, Response $response, array $args) {
		$chat = new Chat($this->db);
		$result = $chat->updateMessage($request->getParsedBody());
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	});
	$app->patch('/lastReadTime', function (Request $request, Response $response, array $args) {
		$chat = new Chat($this->db);
		$result = $chat->updateLastReadTime($request->getParsedBody());
	    $response = $response->withHeader('Content-type', 'application/json' );
		$response = $response->withJson($result);
	    return $response;
	});
});

$app->run();

?>