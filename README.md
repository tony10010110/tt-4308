# Mounty — CMS

Сервіс подорожей кращими місцями Карпат.

## Стек

- **Backend**: Laravel 13, PHP 8.3
- **Frontend**: Vue 3 + Vite (окремий SPA)
- **Database**: MySQL 8.0
- **Auth**: Laravel Sanctum (token-based)
- **Media**: Spatie Media Library
- **Infra**: Docker, Nginx

## Швидкий старт

```bash
# 1. Клонувати репозиторій
git clone <repo-url>
cd tt-4308

# 2. Запустити контейнери (міграції та seed запускаються автоматично)
make build
make up

# 3. API доступне за адресою
http://localhost:8080/api/v1
```

## Адмін доступ (після seed)

| Email | Password |
|-------|----------|
| admin@mounty.ua | password |

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
# Додай заголовок до адмін запитів: Authorization: Bearer <token>
```

### Адмін ендпоінти (потребують `Authorization: Bearer <token>`)

| Resource | URL |
|----------|-----|
| Hero | `/api/v1/admin/hero` |
| Маршрути | `/api/v1/admin/routes` |
| Спорядження | `/api/v1/admin/equipment` |
| Ціни | `/api/v1/admin/prices` |
| FAQ | `/api/v1/admin/faqs` |
| Сторінки | `/api/v1/admin/pages` |

Всі ресурси підтримують `GET`, `POST`, `PUT/PATCH`, `DELETE`.
Для завантаження медіа — `multipart/form-data`.

## Make команди

```bash
make up          # Запустити
make down        # Зупинити
make build       # Перебудувати образи
make logs        # Логи PHP контейнера
make shell       # Shell у PHP контейнері
make fresh       # Скинути БД + seed
make test        # Запустити тести
```

## Структура проєкту

```
.
├── backend/                # Laravel
│   ├── app/
│   │   ├── Http/Controllers/Api/
│   │   │   ├── AuthController.php
│   │   │   ├── PublicController.php
│   │   │   └── Admin/          # CRUD контролери
│   │   └── Models/
│   ├── database/
│   │   ├── migrations/
│   │   └── seeders/
│   └── routes/api.php
├── frontend/               # Vue 3 SPA (в розробці)
├── docker/
│   ├── nginx/default.conf
│   └── php/Dockerfile
└── docker-compose.yml
```
