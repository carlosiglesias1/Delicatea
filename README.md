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

## Execución  

Para executar o proxecto deberemos arrancar o servidor local e dende o navegador poderemos acceder ao backoffice simplemente coa url *localhost/Delicatea/*.  
De momento esa url esta programada para levarnos directamente ao BackOffice, algo que normalmente non debería estar permitido pero que de momento fai que o acceso ao proxecto sexa máis cómodo.
Introduciondo as credenciais admin admin entraremos ao proxecto, dende onde poderemos xestionar a nosa tenda.  
