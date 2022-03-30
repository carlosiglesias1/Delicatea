# Delicatea

Este sería o lado de servidor, aquí os archivos importantes son os que están en [controller/mobile](https://github.com/carlosiglesias1/Delicatea/tree/master/controller/mobile) e en [model](https://github.com/carlosiglesias1/Delicatea/tree/master/model).

## Instalación

### Servidor Web

Para instalar y configurar el servidor será necesario tener instalado un sistema de servidor local, por exemplo [XAMP](https://www.apachefriends.org/es/download.html) ou [WAMP](https://sourceforge.net/projects/wampserver/files/).</br>
Logo gardaremos o proxecto na carpeta que use o servidor para procesar os arquivos web, antes de configurar a base de datos deberemos acceder ao arquivo [AbsolutePaths.php](paths/AbsolutePaths.php) e dentro dese arquivo cambiaremos o valor de ``` $_SESSION['WORKING_PATH'] ``` pola ruta na que teñamos gardado o proxecto +/Delicatea/ (un exemplo sería o valor ```"C:/users/usuario/Documents/webpages```__```/Delicatea/"```__).

### Base de datos

Para crear a base de datos deste proxecto teremos que acceder ao arquivo [tablasDelicatea0.sql](./%23ignorant/CreacionBD/tablasDelicatea0.sql) e executalo no noso servidor de base de datos.  
