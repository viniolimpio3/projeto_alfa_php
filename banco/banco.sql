create database if not exists alpha_php;
use alpha_php;

create table if not exists produto(
	id_prod int not null unique auto_increment,
    name_prod varchar(40) not null unique,
    value_prod decimal(6,2) not null,
    desc_prod text not null,
    primary key(id_prod)
);
create table if not exists cliente(
	id_cliente int not null unique auto_increment,
    name_cliente varchar(40) not null unique,
    end_cliente text not null,
    user_cliente varchar(35) not null unique,
    senha_cliente text not null,
    primary key(id_cliente)
);

create table if not exists pedido(
	id_pedido int not null unique auto_increment,
    data_pedido date not null,
    valor_pedido numeric(7,2) not null,
    status_pedido varchar(35) not null,
    fk_id_cliente int not null,
    fk_id_prod int not null,
    forma_pag varchar(15) NOT NULL,
    n_parcelas int(2) NOT NULL,
    valor_parcelas decimal(7,0) NOT NULL
    primary key(id_pedido),
    foreign key( fk_id_prod ) references produto (id_prod),
    foreign key( fk_id_cliente ) references cliente (id_cliente)
);	

insert into produto(name_prod, value_prod, desc_prod)values
('Toddy', 12.00, 'Achocolatado'),
('Omo', 12.00, 'Produto de Limpeza'),
('Notebook HP', 900.00, 'Eletrônicos'),
('TV Samsung', 1300.00, 'Eletrônicos'),
('Liquidificador', 130.00, 'Eletroeletrônicos');

insert into cliente(name_cliente, end_cliente, user_cliente, senha_cliente)values
('Vinícius','Rua das Abobrinhas, 123', 'vini@any.com', sha1('senha')),
('Phelipe','Rua das Abobrinhas, 124', 'ph@any.com', sha1('senha')),
('Nicolas','Rua das Abobrinhas, 125', 'nico@any.com', sha1('senha')),
('Gabriel','Rua das Abobrinhas, 126', 'biel@any.com', sha1('senha'));

