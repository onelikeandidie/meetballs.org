## Meetballs.org

This project is built using Laravel and FilamentPHP, as well as TailwindCSS and
AlpineJS. To get started, you'll need to have PHP and Composer installed on your
machine and Node.js. I have included a `shell.nix` file for Nix users to get
started with the project using `nix-shell shell.nix`.

If you don't have Nix installed, you'll have to install
[php 8.3](https://www.php.net/downloads), [composer](https://getcomposer.org/)
and [node.js](https://nodejs.org/en/download/). If you use a package manager
please use your package manager's installation method.

Once you have PHP, Composer and Node.js installed, you can run the following
in different terminal windows to serve the project:

```bash
$ php artisan serve
$ npm run watch
```

If you want to run services:

```bash
$ php artisan queue:listen
$ php artisan schedule:work
$ php aritsan reverb:start
```

If you want to follow the logs:

```bash
$ tail -f storage/logs/laravel.log
```

If you don't have a database set up, you can use the `sqlite` driver by
creating a file in the `database` directory called `database.sqlite` and then
running the migrations:

```bash
$ touch database/database.sqlite
$ php artisan migrate
```

Below is a list of projects and sessions that have been hosted on Meetballs.org.

## Projects

- Sessions
    - [Infosec](https://www.meetup.com/geek-sessions-faro/events/302500733) - Discussion about infosec
      and some capture the flag _#infosec_ _#session_ _#featured_
    - [Introduction to Phaser.js](https://github.com/Unisergius/phaser-flappybird-clone) - We make a
      flappy bird clone all in Phaser.js _#javascript_ _#session_
    - [Infosec](https://www.meetup.com/geek-sessions-faro/events/301637182) - Talk with the nerdiest of the nerds to learn how cybersecurity
      works and what you can do to defend yourself. _#infosec_ _#session_
    - [Simple RAG for GitHub issues using HuggingFace.com Zephyr](https://www.meetup.com/geek-sessions-faro/events/301574946/?isFirstPublish=true) - RAG is a popular approach to address the issue of a powerful LLM not being aware of specific content due to said content not being in its training data, or hallucinating even when it has seen it before. Such specific content may be proprietary, sensitive, or, as in this example, recent and updated often.
    - [Python Streamlit Dashboard Kickstarter](https://github.com/Py-ualg/geeksessions-streamlit) - Getting started
      creating a simple cloud dashboard with python and streamlit.io _#session_ _#python_
    - [Test Driven Development with João Cabrita](https://fb.me/e/4qrMfGPPL) - An
      introduction to Test Driven Development _#session_ _#test-driven_
    - [InfoSec](https://www.facebook.com/events/773869947826615/?ref=newsfeed) - Join us for more Infosec adventures. Talk with the nerdiest of the nerds to learn how cybersecurity works and what you can do to defend yourself. _#infosec_ _#session_
    - [Free Day](https://www.facebook.com/events/407939325275462/?ref=newsfeed) - Free day, bring something to the table, any projects ou wanna showcase, do some networking and talk about other events _#wildcard_
    - [Automating pull request reviewing with ChatGPT and webhooks by IS AT Lda's Pedro](https://www.facebook.com/events/1529449120945397/?ref=newsfeed) - This session we'll be looking into how we can use webhooks and LLMs and how combining those can be done to automate workflows, like reviewing pull requests. _#session_ _#chatgpt#_
    - [InfoSec](https://www.facebook.com/events/3775335509421509/) - An introduction to Information Security, how to protect your information from reaching third-parties _#infosec_ _#session_
    - [Langchain with Python and ChatGPT](https://www.facebook.com/events/3756642677927262) - Automating your programing from initial prompt to
      full application _#langchain_ _#python_
    - [Quasar + Supabase + You](https://fb.me/e/3jkI9ydYI) - Introduction to a VueJS framework for creating websites, mobile apps and desktop apps
      all from the same codebase _#node_ _#vuejs_
    - [Free Day](https://fb.me/e/3t1jLwT6V) - Free day, bring something to the table, any projects ou wanna showcase, do some networking and talk about other events
      _#wildcard_
    - [Flutter Installation Party](https://www.facebook.com/events/451186503902037/) - Flutter Installation Party (for the First Timers) _#flutter_ _#mobile_ _#uikit_
    - [Algorithms II - Data Structures](https://www.facebook.com/events/907229467549946) - Learn more about algorithms
      and how to handle big amounts of data _#algorithms_ _#penandpaper_
    - [Prompt Engineering](https://www.facebook.com/events/928880408889510) - Make your AI do what you want _#session_ _#ai_ _#copilot_ _#chatgpt_ _#noguide_
    - [Embedded Systems Workshop](https://github.com/zinixyt/meetballs-embedded-workshop) - Diving
      into the basics of working with ESP32 and Arduino embedded systems using an emulator _#session_
      _#embedded_ _#arduino_ _#esp32_
    - [Algorithm Potpourri](https://www.facebook.com/events/1080560462988839) - Learn, discuss and implement essential
      algorithms you'll forget as soon as you land a job. _#session_
      _#algorithms_ _#penandpaper_
    - [Docker Container Introduction](https://github.com/Unisergius/containers-fccikea-2-2023) - A Docker container
      introduction for the FCC IKEA 2-2023 meetup _#session_ _#docker_
    - [Rust Introduction 29-2023](https://github.com/onelikeandidie/fccikea-29-2023-rust) - A Rust introduction for the FCC
      IKEA 29-2023 meetup _#session_ _#rust_
    - [Simple Math in Nodejs accepting Pull Requests](https://github.com/Unisergius/simple-math-api-exercise) - A simple
      math API in Nodejs for the FCC IKEA 29-2023 meetup to get familiar with accepting pull requests _#session_
    - [Test driven development in Python](https://github.com/Unisergius/fcc-python-tdd-session) - An intro to Red Green Refactor concept of Test Driven Development in Python _#tests_ _#python_
    - [Git and Gitpod](https://github.com/Unisergius/git-fcc-ikea-2023) - Small intro to git, git features, pull, push, pull requests and intro to Gitpod _#git_ _#gitpod_ _#pullrequests_
    - [Typescript](https://github.com/Unisergius/typescript-fccikea-4-2023) - Session about why Typescript over Javascript, pros cons and think upons. _#typescript_
    - [Rust, Rustlings and Rust frameworks](https://github.com/Unisergius/rust-7-april-fcc-ikea) - Session about Rust and Rustlings. Small intro to Rust frameworks _#rust_
    - [Flutter Installation Party](https://github.com/Unisergius/flutter-fccikea-3-2023) - Session from Flutter Faro about Flutter, Google's framework for desktop, web and mobile apps. _#flutter_ _#dart_
- [Meetballs.org](https://meetballs.org) - The Meetballs.org website _#website_
  [Repository](https://github.com/onelikeandidie/meetballs.org)

## License

This project is unlincensed. See the [LICENSE](LICENSE) file for details.
