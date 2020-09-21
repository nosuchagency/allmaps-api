[![Contributors][contributors-shield]][contributors-url]
[![Forks][forks-shield]][forks-url]
[![Stargazers][stars-shield]][stars-url]
[![Issues][issues-shield]][issues-url]
[![MIT License][license-shield]][license-url]

<br />
<p align="center">
  <h3 align="center">AllMaps - The API Version</h3>

  <p align="center">
    AllMaps is an open-source indoor map solution.
    <br />
    <a href="https://docs.allmaps.nosuchagency.net/"><strong>Explore the docs »</strong></a>
    <br />
    <br />
    <a href="https://github.com/nosuchagency/allmaps-api/issues">Report Bug</a>
    ·
    <a href="https://github.com/nosuchagency/allmaps-api/issues">Request Feature</a>
  </p>
</p>

<!-- TABLE OF CONTENTS -->
## Table of Contents

* [About the Project](#about-the-project)
  * [Built With](#built-with)
* [Getting Started](#getting-started)
  * [Prerequisites](#prerequisites)
  * [Installation](#installation)
* [Usage](#usage)
* [Roadmap](#roadmap)
* [Contributing](#contributing)
* [License](#license)
* [Contact](#contact)
* [Acknowledgements](#acknowledgements)

<!-- ABOUT THE PROJECT -->
## About The Project

AllMaps is an open-source indoor map solution.

### Built With
AllMaps is built on top of these fantastic pieces of software.

* [Laravel](https://laravel.com)

<!-- GETTING STARTED -->
## Getting Started

This is a pretty default Laravel application, so if you know Laravel, then it should be streight forward to get started.

### Prerequisites




You need to have Composer, A Dependency Manager for PHP, installed. Go get it <a href="https://getcomposer.org/doc/00-intro.md">Getting Started with Composer</a>.

### Installation

1) Clone the repo

```sh
git clone https://github.com/nosuchagency/allmaps-api.git
```

2) Install Composer packages

```sh
composer install
```

3) Do the migration

```sh
php artisan migrate --seed
```

4) Generate unique keys for your installation

```sh
php artisan key:generate
```

5) Link the storage

```sh
php artisan storage:link
```

There is now seeded an administration user with email, webmaster@nosuchagency.dk, and code, password12.


<!-- USAGE EXAMPLES -->
## Usage

AllMaps API is just that - an API. So you need to create an app to interact with AllMaps. But if you want to manage the content in AllMaps, then install <a href="https://github.com/nosuchagency/allmaps-cms">AllMaps CMS</a>.


<!-- ROADMAP -->
## Roadmap

See the [open issues](https://github.com/nosuchagency/allmaps-api/issues) for a list of proposed features (and known issues).


<!-- CONTRIBUTING -->
## Contributing

Contributions are what make the open source community such an amazing place to be learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

<!-- LICENSE -->
## License

Distributed under the MIT License. See `LICENSE` for more information.

<!-- CONTACT -->
## Contact

Peter Kær - [@peterkaer](https://twitter.com/peterkaer) - peterkaer@nosuchagency.dk

Project Link: [https://github.com/nosuchagency/allmaps-api](https://github.com/nosuchagency/allmaps-api)


<!-- ACKNOWLEDGEMENTS -->
## Acknowledgements

<!-- MARKDOWN LINKS & IMAGES -->
<!-- https://www.markdownguide.org/basic-syntax/#reference-style-links -->
[contributors-shield]: https://img.shields.io/github/contributors/nosuchagency/allmaps-api.svg?style=flat-square
[contributors-url]: https://github.com/nosuchagency/allmaps-api/graphs/contributors

[forks-shield]: https://img.shields.io/github/forks/nosuchagency/allmaps-api.svg?style=flat-square
[forks-url]: https://github.com/nosuchagency/allmaps-api/network/members

[stars-shield]: https://img.shields.io/github/stars/nosuchagency/allmaps-api.svg?style=flat-square
[stars-url]: https://github.com/nosuchagency/allmaps-api/stargazers

[issues-shield]: https://img.shields.io/github/issues/nosuchagency/allmaps-api.svg?style=flat-square
[issues-url]: https://github.com/nosuchagency/allmaps-api/issues

[license-shield]: https://img.shields.io/github/license/nosuchagency/allmaps-api.svg?style=flat-square
[license-url]: https://github.com/nosuchagency/allmaps-api/blob/master/LICENSE.txt

[product-screenshot-one]: readme/allmaps-screenshot-1.png