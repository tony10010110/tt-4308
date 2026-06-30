# Mounty — Сервіс подорожей Карпатами

Laravel 13 + Vue 3 + Docker + MySQL

---

## Вимоги

- [Docker](https://docs.docker.com/get-docker/) + Docker Compose
- Git
- Make (опціонально, але зручно)

---

## 1. Клонування репозиторію

```bash
git clone https://github.com/tony10010110/tt-4308.git
cd tt-4308
```

---

## 2. Створення `.env` файлу

```bash
cp backend/.env.example backend/.env
```

Відкрий `backend/.env` і переконайся що ці значення присутні (вже мають бути):

```env
APP_URL=http://localhost:8080

DB_CONNECTION=mysql
DB_HOST=mysql
DB_PORT=3306
DB_DATABASE=mounty_db
DB_USERNAME=mounty_user
DB_PASSWORD=mounty_password
```

---

## 3. Запуск Docker

```bash
make build
make up
```

або без Make:

```bash
docker compose build --no-cache
docker compose up -d
```

Перша збірка займе 2–5 хвилин. Перевір що всі контейнери запущені:

```bash
docker compose ps
```

Очікуваний результат:

```
NAME           STATUS
mounty_app     Up
mounty_mysql   Up (healthy)
mounty_nginx   Up
mounty_node    Up
```

> **Якщо `mounty_app` постійно рестартує** — перевір логи:
> ```bash
> docker compose logs app
> ```
> Найчастіша причина: відсутній `vendor/` (не встановлені залежності). Вирішення нижче в кроці 4.

---

## 4. Встановлення PHP залежностей

```bash
docker compose exec app composer install
```

> ⚠️ Якщо контейнер `app` рестартує і не дає виконати команду — зупини автозапуск міграцій:
> ```bash
> docker compose stop app
> docker compose run --rm --entrypoint sh app
> composer install
> exit
> docker compose up -d
> ```

---

## 5. Генерація APP_KEY

```bash
docker compose exec app php artisan key:generate
```

---

## 6. Міграції та наповнення БД

```bash
make migrate
make seed
```

або вручну:

```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan db:seed
```

> **Права на storage** — якщо бачиш `Permission denied`:
> ```bash
> docker compose exec app chmod -R 775 storage bootstrap/cache
> docker compose exec app chown -R www-data:www-data storage bootstrap/cache
> ```

---

## 7. Перевірка сайту

> ⚠️ Архітектура: **бекенд** (Laravel API) та **фронтенд** (Vue SPA) працюють на різних портах.

| Сторінка | URL | Сервер |
|----------|-----|--------|
| Головна | http://localhost:5173 | Vite (фронтенд) |
| FAQ | http://localhost:5173/faq | Vite (фронтенд) |
| API | http://localhost:8080/api/v1 | Nginx (бекенд) |

**Фронтенд завжди відкривай на порту `:5173`**, а не `:8080`.

> **Якщо `localhost:5173` недоступний або показує помилку** — перезапусти node контейнер:
> ```bash
> docker compose restart node
> ```
> Якщо помилка пов'язана з правами на `.vite/`:
> ```bash
> docker compose exec node chmod -R 777 /app/.vite
> docker compose restart node
> ```

---

## 8. Адмін панель

Перейди на: **http://localhost:5173/admin/login**

| Поле | Значення |
|------|----------|
| Email | `admin@mounty.ua` |
| Пароль | `password` |

### Розділи адмінки:

| Розділ | URL |
|--------|-----|
| Dashboard | http://localhost:5173/admin |
| Hero секція | http://localhost:5173/admin/hero |
| Маршрути | http://localhost:5173/admin/routes |
| Спорядження | http://localhost:5173/admin/equipment |
| Ціни | http://localhost:5173/admin/prices |
| FAQ | http://localhost:5173/admin/faq |

---

## 10. Корисні команди Make

```bash
make up          # запустити контейнери
make down        # зупинити контейнери
make build       # перезібрати образи
make restart     # перезапустити контейнери
make logs        # логи app контейнера
make logs-all    # логи всіх контейнерів
make shell       # зайти в app контейнер (sh)
make migrate     # виконати міграції
make seed        # наповнити БД тестовими даними
make fresh       # скинути БД і заново мігрувати + seed
make tinker      # Laravel Tinker
make test        # запустити тести
```

---

## 11. Підключення до БД (PhpStorm / DBeaver)

```
Host:     127.0.0.1
Port:     3306
Database: mounty_db
User:     root
Password: root_password
```

> Якщо підключаєшся як `mounty_user` — спочатку виконай:
> ```bash
> docker compose exec mysql mysql -u root -proot_password -e "GRANT ALL ON mounty_db.* TO 'mounty_user'@'%'; FLUSH PRIVILEGES;"
> ```
> Потім: `User: mounty_user`, `Password: mounty_password`

---

## API

### Публічні ендпоінти

| Method | URL | Опис |
|--------|-----|------|
| GET | `/api/v1/hero` | Hero секція |
| GET | `/api/v1/routes` | Список маршрутів |
| GET | `/api/v1/routes/{slug}` | Маршрут деталі |
| GET | `/api/v1/equipment` | Спорядження |
| GET | `/api/v1/prices` | Ціни |
| GET | `/api/v1/faqs` | FAQ |
| GET | `/api/v1/pages/{slug}` | Сторінка |

### Авторизація

```bash
POST /api/v1/auth/login
{ "email": "admin@mounty.ua", "password": "password" }
# Відповідь: { "token": "...", "user": {...} }
# Додай до адмін запитів: Authorization: Bearer <token>
```

### Адмін ендпоінти (потребують `Authorization: Bearer <token>`)

Всі ресурси підтримують `GET`, `POST`, `PUT/PATCH`, `DELETE`.

| Resource | URL |
|----------|-----|
| Hero | `/api/v1/admin/hero` |
| Маршрути | `/api/v1/admin/routes` |
| Спорядження | `/api/v1/admin/equipment` |
| Ціни | `/api/v1/admin/prices` |
| FAQ | `/api/v1/admin/faqs` |
| Сторінки | `/api/v1/admin/pages` |

---

## Структура проєкту

```
tt-4308/
├── backend/                    # Laravel 13 API
│   ├── app/
│   │   ├── Http/Controllers/Api/
│   │   │   ├── AuthController.php
│   │   │   ├── PublicController.php
│   │   │   └── Admin/          # CRUD контролери
│   │   └── Models/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/DatabaseSeeder.php
│   └── routes/api.php
├── frontend/                   # Vue 3 SPA
│   ├── src/
│   │   ├── components/         # AppHeader, AppNav, HeroSection, ActivitySelector
│   │   ├── views/
│   │   │   ├── HomeView.vue
│   │   │   ├── FaqView.vue
│   │   │   └── admin/          # Адмін панель (Login, Dashboard, CRUD)
│   │   ├── stores/auth.js      # Pinia — Sanctum токен
│   │   └── router/index.js
│   └── public/icons/           # SVG іконки
├── docker/
│   ├── nginx/default.conf
│   └── php/
│       ├── Dockerfile
│       └── entrypoint.sh       # auto migrate + seed при старті
├── docker-compose.yml
├── Makefile
└── README.md
```
