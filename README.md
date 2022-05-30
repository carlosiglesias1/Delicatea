# Delicatea

Este sería o lado de servidor e da páxina web, os arquivos deste proxecto conforman toda a estructura de acceso aos datos tanto para a __app móbil__ como para a __web__ e o __Back-Office__.

## Instalación e configuración

### Base de datos

Para crear a base de datos deste proxecto teremos que acceder ao arquivo [tablasDelicatea0.sql](./%23ignorant/CreacionBD/tablasDelicatea0.sql) e executalo no noso servidor de base de datos.  
Isto creará todas as táboas e xerará o usuario __admin: admin__ clásico que posuirá todos os permisos para acceder a todas as seccións do sistema.

### Servidor Web

Para instalar y configurar el servidor será necesario tener instalado un sistema de servidor local, por exemplo [XAMP](https://www.apachefriends.org/es/download.html) ou [WAMP](https://sourceforge.net/projects/wampserver/files/).</br>
Logo gardaremos o proxecto na carpeta que use o servidor para procesar os arquivos web, deberemos acceder ao arquivo [AbsolutePaths.php](paths/AbsolutePaths.php) e dentro dese arquivo cambiaremos o valor de ``` $_SESSION['WORKING_PATH'] ``` pola ruta na que teñamos gardado o proxecto +/Delicatea/ (un exemplo sería o valor ```"C:/users/usuario/Documents/webpages```*```/Delicatea/"```*).  
Despois, para que o sistema poida acceder á base de datos, deberán configurarse correctamente os parámetros do arquivo [bdconfig.php](conection/bdconfig.php); aqui cambiaremos os valores dos campos __*host*__ (equipo que posúe o servidor), __*user*__ (super usuario da base de datos),  __*pass*__ (contrasinal para ese usuario) e __*dbname*__ (nome da base de datos) polos correspondentes en cada caso.

## Funcionamento Interno

O back-end desta aplicación está desenvolvido totalmente en PHP e Javascript, utilizando o patrón de deseño MVC (Model-View-Controller) con controladores desenvolvidos para versión móbil e web, que é a tendencia que está levando o desenvolvemento de aplicacións.

Nos modelos implementei unha estructura de DAO's para modular o acceso aos datos, un connectionPool en PDO para poder ter varias conexións simultáneas e unha DAO factory para en caso de facer migracións, que estas tivesen o mínimo custo de programación posible. 
Todo isto está nos directorios [DAO](model/DAO), [conection](conection/.) e [factory](model/DAO/factory).

As vistas da parte web están implementadas xa nesta parte do sistema, no directorio [view/back](view/back) temos a disposición todas as vistas que hai funcionando no proxecto.  

Por último o directorio [controller](controller) almacena os controladores, neste momento só están en desenvolvemento os do backoffice web [back](controller/back/) e mobil [mobile](controller/mobile/), pero faltaría un 3º e inclusive un 4º que serían os controladores que xestionarían o lado dos ***clientes*** da tenda.

### Entrando en detalle

No directorio [lang](lang) están os ficheiros de idiomas (castelán, galego e inglés) nos que se poderá ler a aplicación, esta función de momento só está dispoñible para algúns textos.

A xestión de arquivos e documentos e arquivos (imaxes, pdf's, etc.) levarase a cabo no propio servidor, debido a que usamos un motor de base de datos que pode estar sostido a cambios e manexar arquivos é unha sobrecarga de traballo, na base de datos gardaranse só as rutas para abrir cada ficheiro, os directorios de acceso a estes arquivos serán [files](files) e [imgs](imgs).

Por outra banda, en [Funciones](Funciones) e [Includes](Includes) temos os arquivos nos que se gardan as funcións comúns a todos os módulos: [funciones.php](Funciones/funciones.php) é no que se fai referencia aos distintos scripts como a carga de [ventás modais](Includes/modal.php) ou a inicialización das táboas de datos, [dataTables.min.js](Includes/DataTables/dataTables.min.js) (un minificado dun table sorter que vin bastante rentable), librerías de [javascript](Includes/js/) e _jquery_([jquery3.5.1](Includes/jquery-3.5.1.js) e [jquery3.6](Includes/jquery3.6.js)) e módulos que non souben onde metelos (exemplo: os módulos de subida de arquivos [uploader.php](Funciones/uploader.php) e [image-uploader.js](Funciones/image-uploader.js).

O directorio [icofont](icofont) contén as iconas que se utilizan na versión web.

#### Módulos de interés


## Execución  

Para executar o proxecto deberemos arrancar o servidor local e dende o navegador poderemos acceder ao backoffice simplemente coa url *localhost/Delicatea/*.  
De momento esa url esta programada para levarnos directamente ao BackOffice, algo que normalmente non debería estar permitido pero que de momento fai que o acceso ao proxecto sexa máis cómodo.
Introduciondo as credenciais admin admin entraremos ao proxecto, dende onde poderemos xestionar a nosa tenda.

## Modo de Uso

Como de momento non temos *front Office*, o sistema levaranos directamente ao *backOffice*, en concreto á ventá de __login__, dende aquí poderemos acceder ao sistema por primeira vez introducindo o usuario admin admin.

Unha vez dentro do sistema poderemos movernos polos distintos apartados do programa a través do menú lateral, cada opción representa unha área de xestión na que poderemos facer operacións CRUD.  
Todas as seccións comezan cunha primeira vista de visualización en modo táboa dos datos que hai subidos en base de datos.

### Usuarios

Dentro do sistema cada usuario que se dea de alta por primeira vez terá uns permisos específicos de acceso ás distintas áreas da base de datos, estes permisos deberán asignarse unha vez teñamos o novo usuario creado e poderán modificarse en calquera momento.

### Marcas

Aquí xestionaranse as distintas marcas que leve a empresa, de momento só está dispoñible como característica dos articulos para filtrara as tarifas, funcionalidades como filtro por proveedor de cada marca ou estadísticas de vendas e informes estarían dispoñíbles en seguintes versións

### Categorías

Nesta sección controlanse as distintas categorías polas que filtrar os nosos productos.

### Subcategorías

Nesta sección controlanse as distintas subcategorías polas que filtrar os nosos productos.

### Artículos

Nesta área é onde se xuntan as 3 seccións anteriores; para dar de alta un artigo necesitaremos ter creada polo menos unha marca, categoría, e subcategoría.
Nesta área de momento é na única na que poderemos subir imaxes, o plan a curto longo prazo sería poder poñer máis imaxes *(por exemplo: en Usuarios e Marcas)*

### IVA

Para poder xestionar os dintintos tipos de IVA dos nosos produtos temos unha sección específica, que teño previsto que se transforme en *Impostos* a posteriori, para dentro dela incluír todos os tipos de tasas en ditintas subseccións.

### Tarifas

Nesta área xestionaremos as distintas tarifas que se poidan facer na nosa empresa, filtrando de momento pola marca, categoría e subcategoría do artigo.
Melloras ap posteriori, filtrar por cliente para poder facer descontos personalizados cando o módulo de clientes esté desenvolvido, filtrar por caducidade se se trata de produtos perecedeiros, permitir tarifas en intervalos a modo de promoción, etc.
