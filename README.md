# Meetballs.org website

This is the source code for the Meetballs.org website. Currently, it lists
some of the projects worked on during the [Meetballs](https://meetballs.org)
developer meetups. The projects can be the script from the host of the meetup,
or a project that was worked on during the meetup.

## Development

The codebase is based on Rocket.rs, Tera templating and Tailwind CSS. To make
sure you have all the required components install Rust from
[rust-lang.org](https://rust-lang.org) and Node.js (along with npm)
[nodejs.org](https://nodejs.org), then run:

```bash
# Install tailwind
npm install
```

To compile styles and run the site locally run the following:

```bash
# Automatically runs tailwind using the build.rs file
cargo run
```

To make sure the styles get compiled whenever you change a template file, you
will have to install `cargo-watch` to add the the ability for cargo to watch
for changes and recompile.

```bash
# Install globaly
cargo install --locked cargo-watch
# Watch for changes and recompile styles
cargo watch
# Watch for changes and recompile whole site
# -x makes cargo run the following command whenever something changes
cargo watch -x run
```

## Submitting a project to list on the website

These projects are actually parsed from the following section of this README
file. in the following format:

```markdown
- [Project Name](https://project.url) - Project description
- [Repo Name](https://github.com/meetballs/repo-name) - Repo description
- [Another Project](https://example.com) - Another project description
  _#project-tag_ [Another link](https://random.dog)
```

If you would like to add a project to the list, please submit a pull request
with the project added to the list in the above format.

## Projects

- Sessions
  - [InfoSec](https://www.facebook.com/events/3775335509421509/) - An introduction to Information Security,
    how to protect your information from reaching third-parties _#infosec_ _#session_ _#featured_
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
