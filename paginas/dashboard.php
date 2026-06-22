<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="./css/padrao.css">

    <style>

        body {
            flex-direction: column;
            justify-content: center;
            align-items: center;
            gap: 30px;
        }

        section {
            display: flex;
            gap: 20px;
        }

        button {
            font-size: 16px;
            font-weight: 600;
            letter-spacing: 0.3px;
            border-radius: 10px;
            padding: 14px 32px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        #button1 {
            background: linear-gradient(135deg, #3b298a 0%, #734afa 100%);
            color: white;
            border: none;
        }

        #button1:hover {
            transform: translateY(-2px);
            box-shadow: 0 0 20px rgba(107, 70, 193, 0.5);
        }

        #button2 {
            background: transparent;
            color: #C4C9FF;
            border: 1.5px solid #6B46C1;
        }

        #button2:hover {
            background: rgba(107, 70, 193, 0.15);
            transform: translateY(-2px);
        }

        img{
            height: 600px;
            width: auto;
        }

    </style>
</head>
<body>
    <img src="./img/logo.png" alt="Logo do Jerico" id="logo">
    <section>
        <button type="button" onclick="window.location.href='login.php'" id="button1">Login</button>
        <button type="button" onclick="window.location.href='cadastro.php'" id="button2">Cadastro</button>
    </section>
</body>
</html>
