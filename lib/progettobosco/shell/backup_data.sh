#!/bin/bash
mysqldump -u root progettobosco_master --ignore-table=progettobosco_master.user --ignore-table=progettobosco_master.user_propriet --ignore-table=progettobosco_master.user_diz_regioni --ignore-table=progettobosco_master.log --ignore-table=progettobosco_master.profile > backup_data.sql
