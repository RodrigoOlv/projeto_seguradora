CREATE DATABASE seguradora;
USE seguradora;

CREATE TABLE cliente(
	id BIGINT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(50) NOT NULL,
    sobrenome VARCHAR(50) NOT NULL,
    cpf BIGINT NOT NULL,
    telefone VARCHAR(15) NOT NULL,
    logradouro VARCHAR(50) NOT NULL,
    numero VARCHAR(5) NOT NULL,
    cep VARCHAR(9) NOT NULL,
    bairro VARCHAR(50) NOT NULL,
    cidade VARCHAR(50) NOT NULL,
    uf CHAR(2) NOT NULL
);

CREATE TABLE veiculo(
	registro BIGINT PRIMARY KEY AUTO_INCREMENT,
    marca VARCHAR(30) NOT NULL,
    modelo VARCHAR(30) NOT NULL,
    placa VARCHAR(8) NOT NULL
);

CREATE TABLE apolice(
	numero BIGINT PRIMARY KEY AUTO_INCREMENT,
    valor FLOAT(10,2) NOT NULL,
    registro_veiculo BIGINT,
    FOREIGN KEY (registro_veiculo) REFERENCES veiculo (registro),
    id_cliente BIGINT,
    FOREIGN KEY (id_cliente) REFERENCES cliente(id)
);

CREATE TABLE acidente(
	codigo_sinistro BIGINT PRIMARY KEY AUTO_INCREMENT,
    local_sinistro VARCHAR(100) NOT NULL,
    data_sinistro DATE NOT NULL,
    horario TIME NOT NULL,
    registro_veiculo BIGINT,
    FOREIGN KEY (registro_veiculo) REFERENCES veiculo (registro)
);

CREATE TABLE usuario(
	id_usuario BIGINT PRIMARY KEY AUTO_INCREMENT,
    login_usuario VARCHAR(50) NOT NULL,
    senha_usuario VARCHAR(50) NOT NULL
);

INSERT INTO usuario (id_usuario, login_usuario, senha_usuario) VALUE (null, "admin", "access");