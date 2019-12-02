# Ứng dụng nhà hàng

## Deployment and/or CI/CD
use laradoc module: https://laradock.io/
```bash
# install docker + docker compose

# add submodule
git submodule add https://github.com/Laradock/laradock.git or
# pull code for submodule
git submodule update --recursive --init

# choice module submodule
cd laradoc
cp env-example .env

# Build the environment and run it using docker-compose
docker-compose up -d nginx mysql
```

```bash
#when laradoc installed
docker-compose exec workspace bash

# install composer
composer install
cp .env.example .env
php artisan key:generate

# Migration and DB seeder (after changing your DB settings in .env)
php artisan migrate --seed

# Generate JWT secret key
php artisan jwt:secret

# install dependency
npm install

# develop
npm run dev # or npm run watch

# Build on production
npm run production

```

## Built with
* [Laravel](https://laravel.com/) - The PHP Framework For Web Artisans
* [VueJS](https://vuejs.org/) - The Progressive JavaScript Framework
* [Element](https://element.eleme.io/) - A  Vue 2.0 based component library for developers, designers and product managers
* [Vue Admin Template](https://github.com/PanJiaChen/vue-admin-template) - A minimal vue admin template with Element UI

## Contributing

Please read [CONTRIBUTING.md](CONTRIBUTING.md) for details on our code of conduct, and the process for submitting pull requests to us.

## Versioning

We use [SemVer](http://semver.org/) for versioning. For the versions available, please look at the [release tags](https://github.com/thuyetpv/laravue/tags) on this repository.

## Authors

* **ThuyetPV** - *Initial work* - [thuyetpv](https://github.com/thuyetphamit).

## License

This project is licensed under the MIT License - see the [LICENSE.md](LICENSE) file for details.

## Acknowledgements

* [vue-element-admin](https://panjiachen.github.io/vue-element-admin/#/) A magical vue admin which insprited Laravue project.
* [tui.editor](https://github.com/nhnent/tui.editor) - Markdown WYSIWYG Editor.
* [Echarts](http://echarts.apache.org/) - A powerful, interactive charting and visualization library for browser.

https://vuejsexamples.com/vuejs-component-for-resizing-and-rotating-html-elements-using-css-transform-matrix/
