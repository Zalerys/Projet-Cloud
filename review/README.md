# Solution Cloud: TP1: Correction

Automatiser les backups
Plus de détails sur les planification de tâches avec cron sur https://crontab.guru/
```shell
crontab -e
```
Ajouter la ligne suivante pour lancer le script de backup toutes les heures
```shell
0 */1 * * * /home/backup.sh
```
