<?php

class Conta {
	public int id_usuario;
	public string plataforma;
	public string url;
	public string email_conta;
	public string login;
	public string senha;
	public string observacoes;  

	public function __construct(id_usuario, plataforma, url, email_conta, login, senha, observacoes) {
		// criptografar a senha
	}

}

