#[macro_use]
extern crate rocket;

use std::sync::Mutex;

use chrono::Datelike;
use meetballs_rs_org::Project;
use rocket::State;
use rocket_dyn_templates::{context, Template};

#[get("/")]
fn home(app_state: &State<Mutex<ProjectsCache>>) -> Template {
    // Get the current date
    let today = chrono::offset::Local::now();
    // Get cached projects
    let projects = {
        let mut app_state = app_state.lock().unwrap();
        if app_state.last_updated < today - chrono::Duration::minutes(5) {
            println!("Updating projects");
            // Update the projects
            app_state.projects = Project::all();
            app_state.last_updated = today;
        }
        app_state.projects.clone()
    };
    // Get the featured project
    let featured_project = projects.iter().find(|p| p.featured).cloned();
    // The next meetup is the next wednesday
    let next_meetup = if today.weekday() == chrono::Weekday::Wed {
        today
    } else {
        // Find the next wednesday
        let days_from_moday = today.weekday().num_days_from_monday() as i8;
        let days_to_add = if days_from_moday <= 2 {
            2 - days_from_moday
        } else {
            9 - days_from_moday
        };
        today + chrono::Duration::days(days_to_add as i64)
    };
    // Render the home page template
    Template::render(
        "index",
        context! {
            projects: projects,
            featured_project: featured_project,
            next_meetup: next_meetup.format("%A, %B %e, %Y").to_string(),
        },
    )
}

#[catch(404)]
fn not_found() -> Template {
    // Render the 404 page template
    Template::render("404", context! {})
}

// The application state
struct ProjectsCache {
    projects: Vec<Project>,
    last_updated: chrono::DateTime<chrono::Local>,
}

#[launch]
fn rocket() -> _ {
    rocket::build()
        // Serve any file on the public directory
        .mount("/public", rocket::fs::FileServer::from("public"))
        // Register routes
        .mount("/", routes!(home))
        // Mount the 404 catcher
        .register("/", catchers![not_found])
        // Add the Tera template support
        .attach(Template::fairing())
        .manage(Mutex::new(ProjectsCache {
            projects: Project::all(),
            last_updated: chrono::offset::Local::now(),
        }))
}
