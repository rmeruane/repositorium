* Repositorium

  Web Engine for Collective Repositories. Based principally on CakePHP and MySQL
  
  Initiated and mainly directed by Jérémy Barbay.
  Participating students listed in Section [[*%20Academic%20History][(Academic) History]]

* Installation
** Requirements
   
   + MySQL 5.1 
   + PHP 5.3 (any php5 should work fine too)
   + Apache 2.2 


** Getting the source

Open a console and get the source

=git clone git://github.com/mquezadav/repositorium.git=

** Configuration

Then you’ll have a copy of the source at local. 

Create the following folders and give these permissions (some of them
already exist):

- =chmod o+w app/tmp=
- =chmod o+w app/tmp/cache=
- =chmod -R o+w app/tmp/cache/persistent=
- =chmod -R o+w app/tmp/cache/models=
- =chmod -R o+w app/tmp/logs=


Copy =database.php.default= to =database.php=, and =core.php.default= 
to =core.php=, and =bootstrap.php.default= to =bootstrap.php= in =app/config=. 

Edit =database.php=:

#+BEGIN_SRC php 
    var $default = array(
        'driver' => 'mysql',
        'persistent' => false,
        'host' => '<HOST>',
        'login' => '<LOGIN>',
        'password' => '<PASSWORD>',
        'database' => '<DBNAME>',
        'prefix' => '',
    );
#+END_SRC

Change =<HOST>=, =<LOGIN>=, =<PASSWORD>= and =<DBNAME>= (database name) to the correspoding values in your system

** Initial DB Dump

1) To load the dump file (=repositorium.sql=) with initial data (users: admin and anonymous). It contains no documents and no criteria. 

   =mysql -u <LOGIN> -p <PASSWORD> <DBNAME> < repositorium.sql=

2) Now you have 2 users: anonymous and admin. The *admin* user has the following atributes
    - Login: admin@example.com
    - Password: password

3) Then add a criteria, and then some documents or users.

** Security

At =core.php= file (=app/config/=), at lines 204 and 209, randomly modify some alphanumeric characters of the corresponding Salt and Cypher Seed. 
Example:

=Configure::write('Security.salt', '<SOME LONG RANDOM STRING>');=

This changes’ll avoid keeping the same session at different app clones, and for security sake.

* (Academic) History:

   1. 2011A: Initial project
      - Project for course "CC5401 - Ingenieria de software"
	Departamento de Ciencias de la Computacion (DCC), University
	of Chile
      - Staff:
	1. Jérémy Barbay -jyby@github (course client) 
	2. Hernan Fierro (project manager) 
	3. Pablo Estefo - pestefo@github (analyst) 
	4. Felipe Banados - fbanados@github (designer) 
	5. Nicolas Perez - thomaslight@github (developer) 
	6. Mauricio Quezada - mquezadav@github (developer) 
	7. David Contreras - dcontrer@github (tester)
      - Object:
	- creation of the first version of the prototype:
	  - only text fragments
	  - simple parameterized quality control
	  - one single repository per server

   2. 2011A: Multi community
      - Internship 
      - Staff:
	1. Jérémy Barbay - jyby@github (advisor) 
	2. Mauricio Quezada - mquezadav@github (developer) 
      - Object: 
	- Clean the code and correct some bugs
	- Extend the engine to support multiple repositories, each
	  with its own parameters and url.
	- install an instance of the engine at http://repositorium.cl

   3. 2011B: Repositorium for Students
      - Internship
      - Staff:
	1. Jérémy Barbay - jyby@github (advisor) 
	2. Carlos Gajardo - cgajardo@github (developer) 
      - Object:
	- Add support for file attachments
	- fill a repository with education files (e.g. pdf of past
	  exams) for students, inspired by the project =Sensei= (now
	  collapsing for lack of participation)
	- propose to some students to use the new repository
	- survey student usage of the new repository

   4. 2011B: Repositorium for Professors
      - Internship
      - Staff:
	1. Jérémy Barbay - jyby@github (advisor) 
	2. Hernan Fierro  (developer) 
      - Object:
	- correction of various bugs
	- implementation of the bug and feature management
	- Add support of visualisation features (e.g. LaTeX, HTML,
	  etc...)
	- fill some repositories with pedagogical material
	  (e.g. solved problems to compose assignments and exams) for
	  professors, inspired by existing ad-hoc repositories
	  (without quality control nor incentive to contribute)
	- propose to some professors to use the new repositories
	- survey professor usage of the new repositories.

   5. 2011B
      - Project for course "CC5401 - Ingenieria de software"
	Departamento de Ciencias de la Computacion (DCC), University
	of Chile
      - Staff:
	1. Jérémy Barbay -jyby@github (course client) 
      - Object:
	- Detection and management of duplicated material
	  - Main aim to counteract the simplest attack consisting to
            resubmit exact copies or minor variants of documents
            already in the repository.
	  - DOES NOT aim to implement advanced "plagiarism" detection.


