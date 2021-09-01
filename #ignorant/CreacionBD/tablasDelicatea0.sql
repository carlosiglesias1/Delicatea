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
  nombre varchar (250) not null
);
CREATE TABLE Articulo (
  idArticulo int AUTO_INCREMENT PRIMARY KEY,
  nombre varchar (50) not null,
  descripcionCorta varchar (100) NOT null,
  descripcionLarga varchar (250) not null
);
ALTER Table
  Articulo
add
  column codigo VARCHAR (150),
add
  column sku VARCHAR(150),
add
  column pn VARCHAR(150),
add
  column marca int references marca(idMarca) on update cascade on delete no action,
add
  column categoria int references categoria(idCategoria) on update cascade on delete cascade,
add
  column subcategoria int references subcategoria(idSubCategoria),
add
  column coste FLOAT,
add
  column iva int references tiposiva(idIVa),
add
  column puntoVerde FLOAT,
add
  column impuestoAlcohol FLOAT;
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
CREATE TABLE caracteristicas (
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
    idRol TINYINT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR (50),
  );
CREATE TABLE usuarios (
    idUsr INT (11) AUTO_INCREMENT PRIMARY KEY,
    nick VARCHAR (50),
    pass VARCHAR (50),
    token VARCHAR (255),
    verificado TINYINT (1),
    rol TINYINT REFERENCES roles (idRol),
    mail VARCHAR (255),
  );
INSERT INTO
  usuarios(nick, pass)
VALUES
  (
    'admin',
    'c7ad44cbad762a5da0a452f9e854fdc1e0e7a52a38015f23f3'
  );
CREATE TABLE TiposIva(
    idIva int AUTO_INCREMENT PRIMARY KEY,
    tipo VARCHAR (50),
    porcentage FLOAT
  );
INSERT INTO
  tiposiva (tipo, porcentage)
VALUES
  ('General', 0.21),
  ('Reducido', 0.1),
  ('Superreducido', 0.4);
CREATE Table ColumnasMenu (
    idCol int AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(25) UNIQUE,
  );
INSERT INTO
  columnasmenu (nombre)
VALUES
  ('Usuarios'),
  ('Marcas'),
  ('Articulos'),
  ('Categorias'),
  ('Subcategorias'),
  ('Clientes'),
  ('Facturas'),
  ('Ventas'),
  ('Contabilidad'),
  ('Iva'),
  ('Tarifas');
CREATE Table permisosMenu (
    idPermiso INT AUTO_INCREMENT PRIMARY KEY,
    usuario INT REFERENCES usuarios(idUsr),
    permiso INT REFERENCES columnasmenu(idCol)
  );
INSERT INTO
  permisosmenu (usuario, permiso)
VALUES
  --Cojer el ID del admin del servidor
  (
    (
      SELECT
        idUsr
      from
        usuarios
      where
        nick = 'admin'
    ),
    1
  ),
  (
    (
      SELECT
        idUsr
      from
        usuarios
      where
        nick = 'admin'
    ),
    2
  ),
  (
    (
      SELECT
        idUsr
      from
        usuarios
      where
        nick = 'admin'
    ),
    3
  ),
  (
    (
      SELECT
        idUsr
      from
        usuarios
      where
        nick = 'admin'
    ),
    4
  ),(
    (
      SELECT
        idUsr
      from
        usuarios
      where
        nick = 'admin'
    ),
    5
  ),
  (
    (
      SELECT
        idUsr
      from
        usuarios
      where
        nick = 'admin'
    ),
    6
  ),
  (
    (
      SELECT
        idUsr
      from
        usuarios
      where
        nick = 'admin'
    ),
    7
  ),(
    (
      SELECT
        idUsr
      from
        usuarios
      where
        nick = 'admin'
    ),
    8
  ),
  (
    (
      SELECT
        idUsr
      from
        usuarios
      where
        nick = 'admin'
    ),
    9
  ),
  (
    (
      SELECT
        idUsr
      from
        usuarios
      where
        nick = 'admin'
    ),
    10
  );
CREATE TABLE tarifas(
    idTarifa int NOT NULL primary key AUTO_INCREMENT,
    nombre VARCHAR(30) NOT NULL,
    formula VARCHAR(100) not NULL,
    origen VARCHAR (20) NOT NULL,
    precioManual FLOAT,
    redondeo FLOAT,
    ajuste FLOAT,
    marca INT references marca(idMarca),
    categoria INT references categoria(idCategoria),
    subcategoria INT references subcategoria(idSubcategoria)
  );
CREATE TABLE tarifasProductos(
    id int NOT NULL primary key AUTO_INCREMENT,
    idPrd int REFERENCES articulo(idArticulo),
    idTarifa int REFERENCES tarifas(idTarifa),
    costeFinal FLOAT
  );
CREATE Table imagenesArticulos(
    path VARCHAR(255) PRIMARY KEY,
    articulo INT REFERENCES articulo(idArtiuclo)
  );