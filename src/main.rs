#[macro_use]
extern crate rocket;

use std::sync::Mutex;

use chrono::Datelike;
use hmac::{Hmac, Mac};
use rocket::http::Status;
use rocket::request::FromRequest;
use rocket::serde::Deserialize;
use meetballs_rs_org::Project;
use rocket::State;
use rocket_dyn_templates::{context, Template};
use sha2::Sha256;

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

#[derive(Debug, Deserialize)]
struct WebhookGithubSignature(String);

#[derive(Debug)]
enum ApiTokenError {
    Missing,
    Invalid,
}

#[rocket::async_trait]
impl<'r> FromRequest<'r> for WebhookGithubSignature {
    type Error = ApiTokenError;

    async fn from_request(request: &'r rocket::Request<'_>) -> rocket::request::Outcome<Self, Self::Error> {
        let secret = request
            .headers()
            .get_one("X-Hub-Signature-256")
            // Remove the sha256= prefix
            .map(|s| s[7..].to_string());
        match secret {
            Some(secret) => rocket::request::Outcome::Success(WebhookGithubSignature(secret)),
            None => rocket::request::Outcome::Error((Status::Unauthorized, ApiTokenError::Missing)),
        }
    }
}

// Create alias for HMAC-SHA256
type HmacSha256 = Hmac<Sha256>;

#[post("/webhook/github", data = "<payload>")]
fn webhook_github(payload: String, webhook_signature: WebhookGithubSignature, config: &State<Config>) -> String {
    println!("Received webhook from GitHub, {:?}", webhook_signature);
    // Get the secret from the config
    let secret = &config.github_secret;
    // Create a HMAC-SHA256 hash
    let mut mac = HmacSha256::new_from_slice(secret.as_bytes()).unwrap();
    mac.update(payload.as_bytes());
    // The problem is github's signature is a hex string and our hash is a byte
    // array so it needs to be converted
    let webhook_signature = hex::decode(webhook_signature.0).unwrap();
    // Verify github's signature
    mac.verify_slice(&webhook_signature)
        .expect("HMAC-SHA256 verification failed");
    // Get the current dir
    let current_dir = std::env::current_dir().unwrap();
    // Pull the changes
    let output = std::process::Command::new("git")
        .current_dir(current_dir)
        .args(&["pull", "origin", "main"])
        .output();
    // Check if the pull was successful
    match output {
        Ok(output) => {
            if output.status.success() {
                let output = String::from_utf8_lossy(&output.stdout);
                println!("Changes pulled: {:?}", output);
                "Changes pulled".to_string()
            } else {
                let output = String::from_utf8_lossy(&output.stderr);
                panic!("Error pulling new changes {:?}", output);
            }
        }
        Err(e) => {
            panic!("Error pulling changes: {:?}", e);
        }
    }
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

#[derive(Debug)]
struct Config {
    github_secret: String,
}

#[launch]
fn rocket() -> _ {
    let github_secret = std::env::var("GITHUB_SECRET").expect("GITHUB_SECRET env var not set");
    rocket::build()
        // Serve any file on the public directory
        .mount("/public", rocket::fs::FileServer::from("public"))
        // Register routes
        .mount("/", routes!(home, webhook_github))
        // Mount the 404 catcher
        .register("/", catchers![not_found])
        // Add the Tera template support
        .attach(Template::fairing())
        .manage(Mutex::new(ProjectsCache {
            projects: Project::all(),
            last_updated: chrono::offset::Local::now(),
        }))
        .manage(Config {
            github_secret,
        })
}
