# @Author: Zazu
# @Date:   2018-10-14 00:52:31
# @Last Modified by:   Zazu
# @Last Modified time: 2018-10-14 15:47:32

# Copy over html files
rm -rf /var/www/html/*
cp -r Website/* /var/www/html/


# Setup Database
mysql --user='ccsep' --password='ccsep_2018' 2>/dev/null < setup.sql
mysql --user='ccsep' --password='ccsep_2018' assignment 2>/dev/null < database.sql
