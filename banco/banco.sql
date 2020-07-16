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
    data_pedido date not null unique,
    valor_pedido numeric(7,2) not null,
    status_pedido varchar(35) not null unique,
    fk_id_cliente int not null unique,
    fk_id_prod int not null unique,
    primary key(id_pedido),
    foreign key( fk_id_prod ) references produto (id_prod),
    foreign key( fk_id_cliente ) references cliente (id_cliente)
);	