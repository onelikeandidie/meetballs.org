use std::path::PathBuf;

use parser::parse;
use rocket::serde::Serialize;

pub mod parser;

#[derive(Serialize, Clone)]
pub struct Project {
    pub name: String,
    pub description: String,
    pub links: Vec<ProjectLink>,
    pub tags: Vec<String>,
    pub featured: bool,
    pub image: String,
}

impl Project {
    pub fn all() -> Vec<Self> {
        let path = PathBuf::from("./README.md");
        if !path.exists() {
            eprintln!("README.md file not found?");
            return vec![];
        }
        parse(path)
    }
}

#[derive(Serialize, Clone)]
pub struct ProjectLink {
    pub name: String,
    pub icon: String,
    pub url: String,
}