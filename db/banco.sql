create table usuario(
    id serial unique not null,
    nome varchar(60) not null,
    email varchar(60) not null unique,
    senha varchar not null,
    status integer not null default 2,
    administrador integer not null default 0
);
insert into usuario (id, nome, email, senha, administrador) values (1, 'Neto', 'claudiorcneto@yahoo.com.br', md5('4520'), 1);
insert into usuario (nome, email, senha, administrador) values ('Lucas', 'lulow0@gmail.com', md5('lu.cas22'), 1);

create table categoria(
    id serial unique not null,
    nome varchar(50) not null,
    usuario integer references usuario(id) default 1
);
insert into categoria (id, nome, usuario) values (1, 'Geral', 1);

create table expenses(
    id serial unique not null,
    usuario integer references usuario(id),
    descricao varchar(60),
    categoria integer references categoria(id) default 1,
    valor double precision not null default 0,
    vencimento date not null default now(),
    pagamento date,
    status integer not null default 2
);

