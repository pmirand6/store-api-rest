#!/bin/bash
mailLog=$(curl https://tienda.feriame.com/clients/sendoffersmail)

#cd
#echo $(date)    >> mail_log_file.log
#echo $mailLog   >> mail_log_file.log
#echo ''         >> mail_log_file.log

echo $mailLog
