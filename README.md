# Verification service

### Technology Stack
* PHP 8.2 + Symfony 6.2 + Nginx
* Docker
* MySQL 8.0
* RabbitMQ
* MailHog
* Gotify

### How to run
```bash
git clone https://github.com/shuraknows/verification-service.git
cd verification-service
docker compose up
``` 
NB!: If you have port conflicts, you can change them in the .env file

### Some links:
* MailHog web interface: http://127.0.0.1:8025/
* RabbitMQ web interface [guest/guest]: http://127.0.0.1:15672/
* Gotify [admin/admin] http://127.0.0.1:18080/

### Endpoints
Render template:
```bash
curl -i -X POST -H 'Content-Type: application/json' http://127.0.0.1:7773/templates/render -d '{
  "slug": "email-verification",
  "variables": {"code": "1234"}
}'
```

Create new verification:
```bash
curl -i -X POST -H 'Content-Type: application/json' http://127.0.0.1:7773/verifications -d '{
  "subject": {
    "identity": "+37120000001",
    "type": "mobile_confirmation"
  }
}'
```

Confirm verification:
```bash
curl -i -X PUT -H 'Content-Type: application/json' http://127.0.0.1:7773/verifications/b249b759-11a7-4b8b-a38d-e53d193d4e90/confirm -d '{
  "code": "727468"
}'
```

### Project structure
```bash
src
├── Application
│   ├── Common
│   │   ├── Decoder
│   │   └── Exception
│   ├── Notification
│   │   ├── Create
│   │   │   └── Service
│   │   └── Dispatch
│   │       └── Service
│   ├── Template
│   │   └── Render
│   │       ├── Factory
│   │       └── Service
│   └── Verification
│       ├── Confirm
│       │   └── Factory
│       └── Create
│           ├── Factory
│           └── Service
├── Domain
│   ├── Common
│   │   └── Entity
│   ├── Notification
│   │   ├── Entity
│   │   ├── Events
│   │   └── Exception
│   ├── Template
│   │   ├── Entity
│   │   └── Exception
│   └── Verification
│       ├── Entity
│       │   └── Subject
│       ├── Events
│       ├── Exception
│       │   ├── Subject
│       │   └── Verification
│       └── Service
└── Infrastructure
    ├── Common
    │   ├── Events
    │   └── Http
    │       └── Listener
    ├── Notification
    │   ├── Amqp
    │   ├── Email
    │   ├── Persistence
    │   │   └── Doctrine
    │   │       └── Mapping
    │   └── SMS
    ├── Template
    │   ├── Http
    │   │   ├── Action
    │   │   └── Client
    │   └── Persistence
    │       └── Doctrine
    │           └── Mapping
    └── Verification
        ├── Amqp
        ├── Http
        │   └── Action
        └── Persistence
            └── Doctrine
                └── Mapping
                    └── Subject

65 directories
```
