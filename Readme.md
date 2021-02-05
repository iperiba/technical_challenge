# Technical Challenge
## How to run
* Se recomiendo desplegarlo en un entorno dockerizado. El utilizado para su desarrollo
  ha sido [Symfony-from-docker](https://github.com/garrongarron/symfony-from-docker)
  

* Se ha optado por emplear la infraestructura de Symfony
  

* El csv del que lee los premios se encuentra en la carpeta  
  `technical_challenge/public/award_list.csv`
  

* Se ha optado por generar csv's con el millón de random codes de cada premio y volcar esos csv directamente
  a la base de datos con la query LOAD DATA INFILE
  

* Para que puedan leerse adecuadamente los csv con códigos generados por el propio sistema se debe 
otorgar permisos de escritura a la carpeta `technical_challenge/public/generatedCsv`
