import sys, getopt
import csv
import mysql.connector
from mysql.connector import errorcode
from database import connect_db, close_db


# Esa funcion muestra las opciones del fichero
def showHelp():
    print('Params:'
           '\n-h                  --> ayuda'
          '\n-e <equip File>     --> carga los datos de equipos con un fichero de equipos'
          '\n-s <stadistic File> --> carga los datos de estadisticas con un fichero de estadisticas'
          '\n-j <player File>    --> carga los datos de jugadores con un fichero de jugadores'
          '\n-p <game File>      --> carga los datos de partidos con un fichero de partidos'
          )


# Esta funcion sirve para insertar la informacion dentro de la base de datos
def insert_contacto_info(csvFile, query):
    # instanciamos la base de datos para tener el cursor para insertar la informacion

    cnx = connect_db()
    cursor = cnx.cursor()

    for line in csvFile:

        try:
            cursor.execute(query, line)
        except mysql.connector.Error as err:
            if err.errno == errorcode.ER_BAD_TABLE_ERROR:
                print("Creating table spam")
            else:
                raise

    # print("La insercion ha ido bien :)")
    cnx.commit()
    cursor.close()
    close_db(cnx)


# Funcion que importa del csv  la informacion y la devuelve como una lista de listas
def importCsv(arg):
    # guardaremos todos los datos en una lista para posteriormente insertarla en la base de datos
    csvResult = []

    # creamos un fichero para abrir el que recibimos como argumentos
    file = open(arg, "r")

    # Creamos la conexion a la base de datos
    cnx = connect_db()
    close_db(cnx)

    # Saltamps la cabecera del csv
    file.readline()

    # Hacemos el reader para que lea el fichero
    reader = csv.reader(file, delimiter=";")

    for line in reader:
        csvResult.append(line)

    file.close()

    return csvResult


def pasarDatosDB(arg, param):
    """
        Esta funcion hace:
            1. Recibe los parametros.
            2. Identifica que tipo de fichero recibe.
            3. Saca la informacion del csv recibido.
            4. Mete la informacion dentro de la tabla correspondiente.
    """

    # Generamos una funcion que devuelva todos los datos y los guarde en una lista de listas
    csvResult = importCsv(arg)

    if param == "equipos":
        queryEquips = ("INSERT INTO equipos "
                       "(nombre, ciudad, conferencia, division) "
                       "VALUES "
                       "(%s, %s, %s, %s)")

        insert_contacto_info(csvResult, query=queryEquips)

    elif param == "estadisticas":
        queryStadistics = (
            "INSERT INTO estadisticas "
            "(temporada, jugador, puntos_por_partido,"
            "asistencias_por_partido, tapones_por_partido, rebotes_por_partido) "
            "VALUES "
            "(%s, %s, %s, %s, %s, %s)")

        insert_contacto_info(csvResult, queryStadistics)

    elif param == "partidos":
        queryGames = (
            "INSERT INTO partidos "
            "(codigo, equipo_local, equipo_visitante, puntos_local, "
            "puntos_visitante, temporada) "
            "VALUES "
            "(%s, %s, %s, %s, %s, %s)")

        insert_contacto_info(csvResult, queryGames)

    elif param == "jugadores":
        queryPlayers = (
            "INSERT INTO jugadores "
            "(codigo, nombre, procedencia, altura, peso, posicion, nombre_equipo) "
            "VALUES "
            "(%s, %s, %s, %s, %s, %s, %s)")

        insert_contacto_info(csvResult, queryPlayers)


def main(argv):
    try:
        opts, args = getopt.getopt(argv, "he:s:j:p:", ["file="])

    except getopt.GetoptError:
        # error en la pasada de parametros del fichero
        showHelp()
        sys.exit(2)

    for opt, arg in opts:

        # opciones que permite el fichero
        if opt == '-h':
            # ayuda del fichero
            showHelp()
            sys.exit()

        # los datos del argumento van dentro del parametro equipos
        elif opt in ("-e", "--file"):
            pasarDatosDB(arg, "equipos")
            pass

        # los datos del argumento van dentro del parametro estadisticcas
        elif opt in ("-s", "--file"):
            pasarDatosDB(arg, "estadisticas")
            pass

        # los datos del argumento van dentro del parametro jugadores
        elif opt in ("-j", "--file"):
            pasarDatosDB(arg, "jugadores")
            pass

        # los datos del argumento van dentro del parametro partidos
        elif opt in ("-p", "--file"):
            pasarDatosDB(arg, "partidos")
            pass


if __name__ == "__main__":
    main(sys.argv[1:])
