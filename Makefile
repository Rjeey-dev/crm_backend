.DEFAULT_GOAL := help

TTY=
DOCKER_COMPOSE_FILE=-f docker-compose.yml

DOCKER_EXEC=docker-compose ${DOCKER_COMPOSE_FILE} exec ${TTY}
DOCKER_RUN=docker-compose ${DOCKER_COMPOSE_FILE} run --rm ${TTY}

.PHONY: help
help: ## Print this help message
	@echo 'Usage:'
	@echo "  make \033[33m<target>\033[0m"
	@echo ''
	@echo 'Targets:'
	@grep -E '^[a-zA-Z_-]+:.*?## .*$$' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}; {printf "  \033[36m%-30s\033[0m %s\n", $$1, $$2}'
	@echo ''

.PHONY: start
start: ## Start docker containers
	docker-compose ${DOCKER_COMPOSE_FILE} up -d --build

.PHONY: stop
stop: ## Stop docker containers
	docker-compose ${DOCKER_COMPOSE_FILE} down
