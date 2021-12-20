#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
chmod 777 -R ../log
php "${DIR}"/restore.php