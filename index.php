<?php
	session_set_cookie_params(["httponly" => true]);
	session_start();

	require_once($_SERVER['DOCUMENT_ROOT'] . "/database/banco.php");

	$_SESSION["id"] = 3;

	if (!isset($_SESSION["id"])) {
		header("location: " . $_SERVER['DOCUMENT_ROOT'] . "/paginas/login.php");
		exit();
	}
	
?>
<!DOCTYPE html>
<html lang="pt-br">
	<head>
		<meta charset="UTF-8">
		<title></title>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
		<link rel="stylesheet" href="./paginas/css/padrao.css">
		<style>
			.sidebar {
	            width: 280px;
	            background: rgba(28, 12, 80, 0.97);
	            border-right: 1px solid rgba(155, 122, 234, 0.3);
	            padding: 2rem 1.5rem;
	            height: 100vh;
	            position: fixed;
	            left: 0;
	            top: 0;
	        }

	        .logo {
	            
	            margin-bottom: 3rem;
	        }

	        .nav-menu {
	            list-style: none;
	        }

	        .nav-item {
	            padding: 14px 20px;
	            margin-bottom: 8px;
	            border-radius: 12px;
	            display: flex;
	            align-items: center;
	            gap: 12px;
	            color: #C4C9FF;
	            cursor: pointer;
	            transition: all 0.3s;
	        }

	        .nav-item.active,
	        .nav-item:hover {
	            background: var(--primary);
	            color: white;
	            transform: translateX(8px);
	        }
		</style>
	</head>
	<body>

		<!-- Sidebar -->
	    <section class="sidebar">
	        <section class="logo"></section>
	        
	        <ul class="nav-menu">
	            <li class="nav-item active" onclick="location.href='index.php'">
	                <i class="fas fa-key"></i>
	                <span>Minhas Contas</span>
	            </li>
	            <li class="nav-item" onclick="location.href='paginas/nova-conta.php'">
	                <i class="fas fa-plus-circle"></i>
	                <span>Nova Conta</span>
	            </li>
	            <li class="nav-item" onclick="location.href='paginas/perfil.php'">
	                <i class="fas fa-user-shield"></i>
	                <span>Perfil</span>
	            </li>
	        </ul>
	    </section>

	    <section>

	    	<?php

	    		



	    	?>

	    </section>
	</body>
</html>
<?php
	

	
	
?>