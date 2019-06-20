# Pet City 2 CMS

## Get started

### Preparing
- Install Docker - https://www.docker.com/community-edition
- Install Docker Compose - https://docs.docker.com/compose/install/
- Install dependencies - `make install`

### Useful commands
- `make install` - installing dependencies and configuring of the environment
- `make run` - run the server
- `make vendor` - update vendor
- `make composer` - run composer
- `make composer cmd=command` - run `composer command`
- `make autoload` - run `composer dumpautoload`
- `make artisan` - run artisan
- `make artisan cmd=command` - run `artisan command`
- `make migrate` - run migrate
- `make refresh` - run migrate with refresh (artisan migrate:refresh --seed)
- `make php` - enter into php container
- `make node` - enter into node container
- `make up` - start docker
- `make down` - strop docker
- `make ps` - show docker status
- `make lint` - run the linter
- `make lintfix` - lint auto fix
