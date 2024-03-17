-- Active: 1710427350908@@127.0.0.1@3306@sg_qui
DROP TABLE IF EXISTS Elemento;
CREATE TABLE IF NOT EXISTS Elemento(
    id                       INT UNSIGNED   AUTO_INCREMENT PRIMARY KEY,
    nome                     VARCHAR(50)    UNIQUE NOT NULL,
    simbolo                  VARCHAR(3)     UNIQUE NOT NULL,
    numero_atomico           INT UNSIGNED   NOT NULL,
    massa_atomica            DECIMAL(10, 4) NOT NULL,
    grupo                    INT,
    periodo                  INT,
    ponto_de_fusao           DECIMAL(10, 2),
    ponto_de_ebulicao        DECIMAL(10, 2),
    densidade                DECIMAL(10, 2),
    estado_padrao            VARCHAR(20),
    configuracao_eletronica  VARCHAR(50),
    propriedades             TEXT,
    createdAt                DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt                DATETIME DEFAULT CURRENT_TIMESTAMP
)engine=InnoDB;

DROP TABLE IF EXISTS Composto;
CREATE TABLE IF NOT EXISTS Composto (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome        VARCHAR(100) NOT NULL,
    createdAt   DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt   DATETIME DEFAULT CURRENT_TIMESTAMP
)engine=InnoDB;

DROP TABLE IF EXISTS Garantia;
CREATE TABLE IF NOT EXISTS Garantia (
    composto    INT UNSIGNED,
    elemento    INT UNSIGNED,
    percentual  DOUBLE(6,3),
    createdAt   DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt   DATETIME DEFAULT CURRENT_TIMESTAMP
)engine=InnoDB;
ALTER TABLE Garantia ADD PRIMARY KEY(composto,elemento);
ALTER TABLE Garantia ADD FOREIGN KEY(composto) REFERENCES composto(id);
ALTER TABLE Garantia ADD FOREIGN KEY(elemento) REFERENCES elemento(id);

DROP TABLE IF EXISTS Cliente;
CREATE TABLE IF NOT EXISTS Cliente (
    id              INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cnpj_cpf        BIGINT UNSIGNED UNIQUE,   
    nome            VARCHAR(100) NOT NULL,
    endereco        JSON,
    email           JSON,
    telefone        JSON,
    data_cadastro   DATETIME DEFAULT CURRENT_TIMESTAMP,
    tipo_cliente    TINYINT, -- {0:'Pessoa Física', 1:'Pessoa Jurídica'}
    status_cliente  TINYINT, -- {0:'Ativo', 1:'Inativo', 2:'Bloqueado'}
    observacoes     TEXT,
    createdAt       DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt       DATETIME DEFAULT CURRENT_TIMESTAMP
)engine=InnoDB;


DROP TABLE IF EXISTS projeto;
CREATE TABLE IF NOT EXISTS Projeto (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cliente     INT UNSIGNED ,
    responsavel INT UNSIGNED ,
    nome        VARCHAR(255) NOT NULL,
    descricao   TEXT,
    data_inicio DATE,
    previsao_termino DATE,
	`status` JSON,
    createdAt DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt DATETIME DEFAULT CURRENT_TIMESTAMP
)engine=InnoDB;
ALTER TABLE projeto ADD FOREIGN KEY(cliente) REFERENCES cliente(id);



DROP TABLE IF EXISTS Usuario;
CREATE TABLE IF NOT EXISTS Usuario (
    id          INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome        VARCHAR(100) NOT NULL,
    email       VARCHAR(100) NOT NULL UNIQUE,
    senha       VARCHAR(255) NOT NULL,    
    permissao   TINYINT, -- {0:'Administrador', 1:'Usuário Normal'}
    avatar      VARCHAR(100),
    `status`    TINYINT, -- {1:'Ativo', 0:'Inativo'}
    createdAt   DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt   DATETIME DEFAULT CURRENT_TIMESTAMP
)engine=InnoDB;


DROP TABLE IF EXISTS projeto_composto;
CREATE TABLE IF NOT EXISTS projeto_composto(
	projeto INT UNSIGNED,
    composto INT UNSIGNED,
    usuario	INT UNSIGNED,
    percentual DOUBLE(6,3),
    createdAt   DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt   DATETIME DEFAULT CURRENT_TIMESTAMP
)engine=InnoDB;
ALTER TABLE projeto_composto ADD PRIMARY KEY(projeto,composto);
ALTER TABLE projeto_composto ADD FOREIGN KEY(projeto) REFERENCES projeto(id);
ALTER TABLE projeto_composto ADD FOREIGN KEY(composto) REFERENCES composto(id);
ALTER TABLE projeto_composto ADD FOREIGN KEY(usuario) REFERENCES usuario(id);



DROP TABLE IF EXISTS responsavel;
CREATE TABLE IF NOT EXISTS responsavel(
	id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
    projeto INT UNSIGNED,
    usuario INT UNSIGNED,
    data_inicio DATE,
	data_termino DATE,
    createdAt   DATETIME DEFAULT CURRENT_TIMESTAMP,
    updatedAt   DATETIME DEFAULT CURRENT_TIMESTAMP
)engine=InnoDB;
ALTER TABLE responsavel ADD FOREIGN KEY(usuario) REFERENCES usuario(id);
ALTER TABLE responsavel ADD FOREIGN KEY(projeto) REFERENCES projeto(id);

