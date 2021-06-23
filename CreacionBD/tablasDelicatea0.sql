CREATE TABLE Clientes (
	idCli int AUTO_INCREMENT PRIMARY KEY,
    dni char (9) not null,
    nombre varchar (50) not null,
	email varchar (250) not null,
    telefono char (9) not null,
    pass varchar (250) not null
);

CREATE TABLE Direcciones (
    idDir int AUTO_INCREMENT PRIMARY KEY,
    cliente int REFERENCES clientes (idCli),
    pais VARCHAR (100),
    provincia varchar (100),
    cp varchar (20),
    poblacion VARCHAR (100)
);

CREATE TABLE Marca (
	idMarca int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar (250)not null
);

CREATE TABLE Articulo (
	idArticulo int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar (50)not null,
    descripcionCorta varchar (100)NOT null,
    descripcionLarga varchar (250) not null
);

CREATE TABLE Categoria (
	idCategoria int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar (50) not null,
    descripcion varchar (100)
);

CREATE TABLE Subcategoria (
	idSubCategoria int AUTO_INCREMENT PRIMARY KEY,
    nombre varchar (50) not null,
    descripcion varchar (100),
    categoria int REFERENCES Categoria (idCategoria)
);

CREATE TABLE CategoriaArticulo (
    articulo int REFERENCES Articulo (idArticulo),
    subcategoria int REFERENCES Subcategoruia (idSubCategoria),
    PRIMARY KEY (articulo, subcategoria)
);


