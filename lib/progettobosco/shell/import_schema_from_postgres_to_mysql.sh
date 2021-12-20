#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
php "${DIR}"/import_schema_from_postgres_to_mysql.php "$1" "$2" "$3" "$4"