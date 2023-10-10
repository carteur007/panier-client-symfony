#---Symfony-And-Makefile---------------#
# Author: https://github.com/yoanbernabeu
# License: MIT
#---------------------------------------------##
#---VARIABLES---------------------------------#

#---COMPOSER-#
COMPOSER = composer
COMPOSER_INSTALL = $(COMPOSER) install
COMPOSER_UPDATE = $(COMPOSER) update
#------------#

#---SYMFONY--#
SYMFONY = symfony 
SYMFONY_NEW_POJECTS = $(SYMFONY) new
SYMFONY_SERVER_START = $(SYMFONY) serve -d
SYMFONY_SERVER_STOP = $(SYMFONY) server:stop
SYMFONY_CONSOLE = $(SYMFONY) console
SYMFONY_LINT = $(SYMFONY_CONSOLE) lint:

help: ## Show this help.
	@echo "Symfony-And-Makefile"
	@echo "---------------------------"
	@echo "Utilisation: make [target]"
	@echo ""
	@echo "Targets:"
	@grep -E '(^[a-zA-Z0-9_-]+:.*?##.*$$)|(^##)' $(MAKEFILE_LIST) | awk 'BEGIN {FS = ":.*?## "}{printf "\033[32m%-30s\033[0m %s\n", $$1, $$2}' | sed -e 's/\[32m##/[33m/'
#---------------------------------------------#
## === 🎛️  SYMFONY ===============================================
sf: ## Liste et Utilise toutes les commandees Symfony (make sf commande="nom-de-la-commande").
	$(SYMFONY_CONSOLE) $(command)
.PHONY: sf

sf-start: ## Start symfony server.
	$(SYMFONY_SERVER_START)
.PHONY: sf-start

sf-stop: ## Stop symfony server.
	$(SYMFONY_SERVER_STOP)
.PHONY: sf-stop

sf-cc: ## Clear symfony cache.
	$(SYMFONY_CONSOLE) cache:clear
.PHONY: sf-cc

sf-log: ## Show symfony logs.
	$(SYMFONY) server:log
.PHONY: sf-log

sf-cd: ## Show symfony default configuration for an extension.
	$(SYMFONY) config:dump-reference  
.PHONY: sf-cd

sf-dauto: ## List classes/interfaces you can use for autowiring.
	$(SYMFONY) debug:autowiring 
.PHONY: sf-dauto

sf-dcf: ## Dump the current configuration for an extension.
	$(SYMFONY) debug:config             
.PHONY: sf-dcf

sf-dcc: ## Display current services for an application.
	$(SYMFONY) debug:container             
.PHONY: sf-dcc

sf-denv: ##  Lists all dotenv files with variables and values
	$(SYMFONY) debug:dotenv             
.PHONY: sf-denv

sf-devent: ##  Display configured listeners for an application
	$(SYMFONY) debug:event-dispatcher             
.PHONY: sf-devent

sf-dform: ##  Display form type information
	$(SYMFONY) debug:form             
.PHONY: sf-dform

sf-dval: ##  Display validation constraints for classes
	$(SYMFONY) debug:validator             
.PHONY: sf-dval

sf-drouter: ##  Display current routes for an application
	$(SYMFONY) debug:router             
.PHONY: sf-drouter

sf-dtwig: ##  Show a list of twig functions, filters, globals and tests
	$(SYMFONY) debug:twid             
.PHONY: sf-dtwig


sf-ddc: ## Create symfony database.
	$(SYMFONY_CONSOLE) doctrine:database:create --if-not-exists
.PHONY: sf-ddc

sf-ddd: ## Drop symfony database.
	$(SYMFONY_CONSOLE) doctrine:database:drop --if-exists --force
.PHONY: sf-ddd

sf-shupf: ## Update symfony schema database.
	$(SYMFONY_CONSOLE) doctrine:schema:update --force
.PHONY: sf-shupf

sf-mm: ## Make migrations.
	$(SYMFONY_CONSOLE) make:migration
.PHONY: sf-mm

sf-dmm: ## Migrate.
	$(SYMFONY_CONSOLE) doctrine:migrations:migrate --no-interaction
.PHONY: sf-dmm
sf-dccer: ##  Clear a second-level cache entity region.
	$(SYMFONY_CONSOLE) doctrine:cache:clear-entity-region  
.PHONY: sf-dccer
sf-dccm: ##  Clear all metadata cache of the various cache drivers.
	$(SYMFONY_CONSOLE) doctrine:cache:clear-metadata
.PHONY: sf-dccm
sf-dccq: ## Clear all query cache of the various cache drivers.
	$(SYMFONY_CONSOLE) doctrine:cache:clear-query
.PHONY: sf-dccq
sf-dccqreg: ##  Clear a second-level cache query region.
	$(SYMFONY_CONSOLE) doctrine:cache:clear-query-region
.PHONY: sf-dccqreg
sf-dccres: ## Clear all result cache of the various cache drivers.
	$(SYMFONY_CONSOLE) doctrine:cache:clear-result
.PHONY: sf-dccres
sf-deps: ## Verify that Doctrine is properly configured for a production environment.
	$(SYMFONY_CONSOLE) doctrine:ensure-production-settings
.PHONY: sf-deps
sf-dmc: ## [orm:convert:mapping] Convert mapping information between supported formats.
	$(SYMFONY_CONSOLE) doctrine:mapping:convert
.PHONY: sf-dmc
sf-dmimp: ## Imports mapping information from an existing database.
	$(SYMFONY_CONSOLE) doctrine:mapping:import
.PHONY: sf-dmimp
sf-dminfo: ## Show basic information about all mapped entities.
	$(SYMFONY_CONSOLE) doctrine:mapping:info
.PHONY: sf-dminfo
sf-dmcure: ## [current] Outputs the current version.
	$(SYMFONY_CONSOLE) doctrine:migrations:current
.PHONY: sf-dmcure
sf-dmdiff: ## [diff] Generate a migration by comparing your current database to your mapping information..
	$(SYMFONY_CONSOLE) doctrine:migrations:diff
.PHONY: sf-dmdiff
sf-dmdsh: ## [dump-schema] Dump the schema for your database to a migration..
	$(SYMFONY_CONSOLE) doctrine:migrations:dump-schema
.PHONY: sf-dmdsh
sf-dmexec: ## [execute] Execute one or more migration versions up or down manually..
	$(SYMFONY_CONSOLE) doctrine:migrations:execute
.PHONY: sf-dmexec
sf-dmgen: ## [generate] Generate a blank migration class..
	$(SYMFONY_CONSOLE) doctrine:migrations:generate
.PHONY: sf-dmgen
sf-dmlast: ## [latest] Outputs the latest version.
	$(SYMFONY_CONSOLE) doctrine:migrations:latest
.PHONY: sf-dmlast
sf-dmlist: ## [list-migrations] Display a list of all available migrations and their status..
	$(SYMFONY_CONSOLE) doctrine:migrations:list
.PHONY: sf-dmlist
sf-dmstatus: ## [status] View the status of a set of migrations..
	$(SYMFONY_CONSOLE) doctrine:migrations:status
.PHONY: sf-dmstatus
sf-dmsync: ##  [sync-metadata-storage] Ensures that the metadata storage is at the latest version..
	$(SYMFONY_CONSOLE) doctrine:migrations:sync-metadata-storage
.PHONY: sf-dmsync
sf-dismup: ## [up-to-date] Tells you if your schema is up-to-date..
	$(SYMFONY_CONSOLE) doctrine:migrations:up-to-date
.PHONY: sf-dismsup
sf-dshc: ## Processes the schema and either create it directly on EntityManager Storage Connection or generate the SQL output.
	$(SYMFONY_CONSOLE) doctrine:schema:create
.PHONY: sf-dshc
sf-dshd: ## Drop the complete database schema of EntityManager Storage Connection or generate the corresponding SQL output.
	$(SYMFONY_CONSOLE) doctrine:schema:drop --force
.PHONY: sf-dshd
sf-dshup: ## Executes (or dumps) the SQL needed to update the database schema to match the current mapping metadata.
	$(SYMFONY_CONSOLE) doctrine:schema:update --complete --force
.PHONY: sf-dshup
sf-dshval: ## Validate the mapping files.
	$(SYMFONY_CONSOLE) doctrine:schema:validate
.PHONY: sf-dshval
sf-mfix: ## Make fixtures.
	$(SYMFONY_CONSOLE) make:fixtures
.PHONY: sf-fix
sf-lfix: ## Load fixtures.
	$(SYMFONY_CONSOLE) doctrine:fixtures:load --no-interaction
.PHONY: sf-lfix
sf-me: ## Make symfony entity.
	$(SYMFONY_CONSOLE) make:entity
.PHONY: sf-me
sf-mc: ## Make symfony controller.
	$(SYMFONY_CONSOLE) make:controller
.PHONY: sf-mc
sf-mf: ## Make symfony Form.
	$(SYMFONY_CONSOLE) make:form
.PHONY: sf-mf
sf-mauth: ## Creates a Guard authenticator of different flavors
	$(SYMFONY_CONSOLE) make:auth
.PHONY: sf-mauth
sf-mcrud: ##  Creates CRUD for Doctrine entity class.
	$(SYMFONY_CONSOLE) make:crud
.PHONY: sf-mcrud
sf-mcmd: ##  Creates a new command.
	$(SYMFONY_CONSOLE) make:command
.PHONY: sf-mcmd
sf-msms: ##  Creates a new message and handler.
	$(SYMFONY_CONSOLE) make:message
.PHONY: sf-msms
sf-msmsm: ##  Creates a new messenger middleware.
	$(SYMFONY_CONSOLE) make:messenger-middleware
.PHONY: sf-msmsm
sf-mrform: ##  Creates a new registration form system.
	$(SYMFONY_CONSOLE) make:registration-form
.PHONY: sf-mrform
sf-mrespass: ##  Create controller, entity, and repositories for use with symfonycasts/reset-password-bundle.
	$(SYMFONY_CONSOLE) make:reset-password
.PHONY: sf-mrsspass
sf-msflogin: ##  Generate the code needed for the form_login authenticator.
	$(SYMFONY_CONSOLE) make:security:form-login
.PHONY: sf-msflogin
sf-msencode: ##  Creates a new serializer encoder class.
	$(SYMFONY_CONSOLE) make:serializer:encoder
.PHONY: sf-msencode
sf-msnorm: ##  Creates a new serializer normalizer class.
	$(SYMFONY_CONSOLE) make:serializer:normalizer
.PHONY: sf-msnorm
sf-mstc: ##  .reates a new Stimulus controller.
	$(SYMFONY_CONSOLE) make:stimulus-controller
.PHONY: sf-mstc
sf-msub: ##  Creates a new event subscriber class.
	$(SYMFONY_CONSOLE) make:subscriber
.PHONY: sf-msub
sf-mtest: ##  [make:unit-test|make:functional-test] Creates a new test class.
	$(SYMFONY_CONSOLE) make:test
.PHONY: sf-mtest
sf-mtwigc: ##  Creates a twig (or live) component.
	$(SYMFONY_CONSOLE) make:twig-component
.PHONY: sf-mtwigc
sf-mtwigext: ##  Creates a new Twig extension with its runtime class.
	$(SYMFONY_CONSOLE) make:fortwig-extensionm
.PHONY: sf-mtwigext
sf-muser: ##  Creates a new security user class.
	$(SYMFONY_CONSOLE) make:user
.PHONY: sf-muser
sf-mval: ##  Creates a new validator and constraint class.
	$(SYMFONY_CONSOLE) make:validator
.PHONY: sf-mval
sf-mvoter: ##  Creates a new security voter class
	$(SYMFONY_CONSOLE) make:voter
.PHONY: sf-mvoter
sf-rmatch: ##  Help debug routes by simulating a path info match.
	$(SYMFONY_CONSOLE) make:router:match 
.PHONY: sf-rmatch

sf-perm: ## Fix permissions.
	chmod -R 777 var
.PHONY: sf-perm

sf-sudo-perm: ## Fix permissions with sudo.
	sudo chmod -R 777 var
.PHONY: sf-sudo-perm

sf-dump-env: ## Dump env.
	$(SYMFONY_CONSOLE) debug:dotenv
.PHONY: sf-dump-env

sf-dump-env-container: ## Dump Env container.
	$(SYMFONY_CONSOLE) debug:container --env-vars
.PHONY: sf-dump-env-container

sf-dump-routes: ## Dump routes.
	$(SYMFONY_CONSOLE) debug:router
.PHONY: sf-dump-routes

sf-open: ## Open project in a browser.
	$(SYMFONY) open:local
.PHONY: sf-open

sf-open-email: ## Open Email catcher.
	$(SYMFONY) open:local:webmail
.PHONY: sf-open-email

sf-checkr: ## Check requirements.
	$(SYMFONY) check:requirements
.PHONY: sf-checkr
#---------------------------------------------#
