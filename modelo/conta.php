<?php

class Conta {
	public int $id_usuario;
	public string $plataforma;
	public string $url;
	public string $email_conta;
	public string $login;
	public string $senha;
	public string $observacoes;  

	public function __construct($id_usuario, $plataforma, $url, $email_conta, $login, $senha, $observacoes) {
		$this->id_usuario = $id_usuario;
		$this->plataforma = $plataforma;
		$this->url = $url;
		$this->email_conta = $email_conta;
		$this->login = $login;
		$this->senha = $senha;
		$this->observacoes = $observacoes;
	}

}

