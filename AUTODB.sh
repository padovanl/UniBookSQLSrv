#serve per rigenerare automaticamente il DB (aggiornato al 01/01/2018)

php artisan migrate:fresh

echo "Migrate completate"
php artisan db:seed --class=DatabaseSeeder
echo "DatabaseSeeder eseguito"
php artisan db:seed --class=PostSeeder
echo "PostSeeder eseguito"
php artisan db:seed --class=CommentSeeder
echo "CommentSeeder eseguito"

