#!/bin/bash
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" && pwd )"
phpdoc -d ../lib/pb -t ../doc/
php "${DIR}"/backup.php