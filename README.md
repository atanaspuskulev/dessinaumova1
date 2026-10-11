### A docker compose app to bring up and work with.

This is a multi-image build using docker compose. Utilizing PHP-FPM, Nginx and MariaDB.

The MariaDB credentials are passed via the .env file, so it should be present on build
and bringing containers up.

```cp .env.example .env```

Note, that if you do not change the container name, the DB_HOST should be set to "db" as this is 
the internal network hostname to the MariaDB server.

### Setup

After copying .env.example -> .env, make sure you have the correct DB_HOST configured.

```docker compose build```
```docker compose up```

If, on build stage you have no 'composer install' executed, do it now first:

```docker compose exec php composer install```

After the images are pulled and up, you have to migrate and seed the database:

```docker compose exec php php migrate```
and
```docker compose exec php php db:seed```


