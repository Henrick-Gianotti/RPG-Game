CREATE DATABASE RPG;
USE RPG;

CREATE TABLE usuario(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome_usuario VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    codigo_recuperacao VARCHAR(16) NOT NULL UNIQUE
);

CREATE TABLE personagem(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    classe VARCHAR(60) NOT NULL,
    nivel INT NOT NULL DEFAULT 1,
    gold DECIMAL (10,2),
    hp_maximo DECIMAL (6,2),
    hp_atual DECIMAL (6,2),
    mp_maximo DECIMAL (6,2),
    mp_atual DECIMAL (6,2),
    id_usuario INT NOT NULL,
    CONSTRAINT fk_personagem_usuario FOREIGN KEY (id_usuario) REFERENCES usuario(id) ON DELETE CASCADE
);

CREATE TABLE classe(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    hp DECIMAL (6,2),
    mp DECIMAL (6,2)
);

CREATE TABLE item(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(6,2),
    raridade VARCHAR(30),
    empilhavel BOOLEAN NOT NULL DEFAULT FALSE,
    item_categoria VARCHAR(50) NOT NULL
);

CREATE TABLE inimigo(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(100) NOT NULL,
    vida INT,
    dano INT,
    saque_gold INT,
    drop_item_id INT NULL,
    drop_chance DECIMAL(3, 2) NULL,
    CONSTRAINT fk_inimigo_drop_item FOREIGN KEY (drop_item_id) REFERENCES item(id) ON DELETE SET NULL
);

CREATE TABLE inventario(
    id INT Primary KEY AUTO_INCREMENT,
    id_personagem INT NOT NULL,
    id_item INT NOT NULL,
    quantidade INT NOT NULL DEFAULT 1,
    equipado BOOLEAN NOT NULL DEFAULT FALSE,
    CONSTRAINT fk_inventario_personagem FOREIGN KEY (id_personagem) REFERENCES personagem(id) ON DELETE CASCADE,
    CONSTRAINT fk_inventario_item FOREIGN KEY (id_item) REFERENCES item(id) ON DELETE CASCADE,
    UNIQUE (id_personagem, id_item)
);

CREATE TABLE arma(
    id_item INT PRIMARY KEY,
    dano INT,
    velocidade_ataque DECIMAL(3,2),
    dano_tipo VARCHAR(30),
    CONSTRAINT fk_arma_item FOREIGN KEY (id_item) REFERENCES item(id) ON DELETE CASCADE
);

CREATE TABLE armadura(
    id_item INT PRIMARY KEY,
    defesa_fisica INT,
    defesa_magica INT,
    local_corpo VARCHAR(60),
    CONSTRAINT fk_armadura_item FOREIGN KEY (id_item) REFERENCES item(id) ON DELETE CASCADE
);

CREATE TABLE pocao(
    id_item INT PRIMARY KEY,
    duracao INT,
    CONSTRAINT fk_pocao_item FOREIGN KEY (id_item) REFERENCES item(id) ON DELETE CASCADE
);

CREATE TABLE efeito(
    id INT PRIMARY KEY AUTO_INCREMENT,
    nome VARCHAR(120) NOT NULL UNIQUE,
    tipo_efeito VARCHAR(40) NOT NULL,
    descricao TEXT
);

CREATE TABLE efeito_arma(
    arma_item_id INT NOT NULL,
    id_efeito INT NOT NULL,
    valor_efeito DECIMAL(6,2),
    PRIMARY KEY (arma_item_id, id_efeito),
    FOREIGN KEY (arma_item_id) REFERENCES arma(id_item) ON DELETE CASCADE,
    FOREIGN KEY (id_efeito) REFERENCES efeito(id) ON DELETE CASCADE
);

CREATE TABLE efeito_armadura(
    armadura_item_id INT NOT NULL,
    id_efeito INT NOT NULL,
    valor_efeito DECIMAL(6,2),
    PRIMARY KEY (armadura_item_id, id_efeito),
    FOREIGN KEY (armadura_item_id) REFERENCES armadura(id_item) ON DELETE CASCADE,
    FOREIGN KEY (id_efeito) REFERENCES efeito(id) ON DELETE CASCADE
);

CREATE TABLE efeito_pocao(
    pocao_item_id INT NOT NULL,
    id_efeito INT NOT NULL,
    valor_efeito DECIMAL(6,2),
    PRIMARY KEY (pocao_item_id, id_efeito),
    FOREIGN KEY (pocao_item_id) REFERENCES pocao(id_item) ON DELETE CASCADE,
    FOREIGN KEY (id_efeito) REFERENCES efeito(id) ON DELETE CASCADE
);

INSERT INTO classe (nome, hp, mp) VALUES 
('Warrior', 125, 50),
('Archer', 100, 75),
('Mage', 75, 150),
('Assassin', 75, 75);

