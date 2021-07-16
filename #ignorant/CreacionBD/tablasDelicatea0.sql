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

CREATE  TABLE caracteristicas (
    idCaracteristica int auto_increment PRIMARY KEY,
    nombre varchar (100)
);

CREATE TABLE caracteristicasSubCat (
    subcategoria int REFERENCES subcategoria (idSubCategoria),
    caracteristicas INT REFERENCES caracteristicas (idCaracterisitca)
);

CREATE TABLE valoresArticulo (
    articulo int REFERENCES articulo (idArticulo),
    caracteristica int REFERENCES caracteristicas (idCaracteristica),
    valor VARCHAR (20)    
);

CREATE TABLE roles (
    idRol INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR (50),
);

CREATE TABLE usuarios (
    idUsr INT (11) AUTO_INCREMENT PRIMARY KEY,
    nick VARCHAR (50),
    pass VARCHAR (50),
    token VARCHAR (255),
    verificado TINYINT (1),
    rol TINYINT,
    mail VARCHAR (255),
)