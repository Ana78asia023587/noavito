.PHONY: help
.DEFAULT_GOAL := help

help:
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "\033[36m%-30s\033[0m %s\n", $$1, $$2}'

build-base-image: ## Сборка образа
	docker build -t app-image -f docker/base.Dockerfile .

up: ## Запуск локального окружения
	docker-compose -p app -f docker-compose.local.yml -f docker-compose.override.yml up -d

up-test: ## Запуск локального окружения для тестирования
	docker-compose -p app --profile test -f docker-compose.local.yml -f docker-compose.override.yml up -d

down: ## Остановка локального окружения
	docker-compose -p app -f docker-compose.local.yml -f docker-compose.override.yml down

down-test: ## Остановка локального окружения для тестирования
	docker-compose -p app --profile test -f docker-compose.local.yml -f docker-compose.override.yml down

cli: ## Подключение к консоли контейнера
	docker-compose -p app -f docker-compose.local.yml -f docker-compose.override.yml exec app bash

logs: ## Логи
	docker-compose -p app -f docker-compose.local.yml -f docker-compose.override.yml logs -f

status: ## Статус контейнеров
	docker-compose -p app -f docker-compose.local.yml -f docker-compose.override.yml ps

# HELPERS
format:
	php-cs-fixer fix app


