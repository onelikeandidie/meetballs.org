use std::path::PathBuf;

use crate::{Project, ProjectLink};

/// The projects are listen in the README.md file at the root of the project.
/// The format is:
/// ```markdown
/// ## Projects
/// - [Project Name](project-url) - Project description _#tag1_ _#tag2_
///     [Repository](repository-url)
/// - [Project Name](repository-url) - Project long description, very much
///     long description _#tag1_ _#tag2_
/// ```
pub fn parse(path: PathBuf) -> Vec<Project> {
    let mut projects = vec![];
    let file = std::fs::read_to_string(path).unwrap();
    let mut is_in_projects_section = false;
    let mut last_project: Option<Project> = None;

    for line in file.lines() {
        if line.starts_with("## Projects") {
            is_in_projects_section = true;
            continue;
        }
        if !is_in_projects_section {
            continue;
        }
        // Trim line content
        let line = line.trim();
        // Skip empty lines
        if line.is_empty() {
            continue;
        }
        // If a line starts with a # then we should be out of the projects section
        if line.starts_with("#") {
            is_in_projects_section = false;
            continue;
        }
        // Skip lines that don't start with a dash
        if line.starts_with("- ") {
            // Remove the dash and the space
            let line = &line[2..];
            // If the line does not start with a [ it's just a list item
            if !line.starts_with("[") {
                continue;
            }
            // Get the name of the project
            let name_end = line.find("](").unwrap();
            let name = &line[1..name_end];
            // Get the URL of the project
            let url_end = line.find(") - ").unwrap();
            let url = &line[name_end + 2..url_end];
            // Get the description of the project
            // it's the rest of the line
            let description = &line[url_end + 4..];
            if let Some(mut project) = last_project.take() {
                // Extract tags before pushing
                project.tags = extract_tags(&mut project.description);
                // Extract image before pushing
                project.image = extract_image(&mut project.description);
                // Extract links before pushing
                project
                    .links
                    .append(&mut extract_links(&mut project.description));
                projects.push(project);
            }
            last_project = Some(Project {
                name: name.to_string(),
                description: description.to_string(),
                links: vec![ProjectLink {
                    name: name.to_string(),
                    icon: get_icon_for_url(url.to_string()),
                    url: url.to_string(),
                }],
                tags: vec![],
                featured: false,
                image: "".to_string(),
            });
        } else {
            // If the line is not a new project and there is currently a
            // project on the stack then this line must be a residual
            // description for the current project
            if let Some(ref mut project) = last_project {
                project.description.push(' ');
                project.description.push_str(line);
                continue;
            }
            // If there is no project on the stack then this line is
            // not part of the projects section
            break;
        }
    }

    if let Some(mut project) = last_project.take() {
        // Extract tags before pushing
        project.tags = extract_tags(&mut project.description);
        // Extract image before pushing
        project.image = extract_image(&mut project.description);
        // Extract links before pushing
        project
            .links
            .append(&mut extract_links(&mut project.description));
        projects.push(project);
    }

    // Tag the featured project
    if let Some(featured_project) = projects
        .iter_mut()
        .find(|p| p.tags.contains(&"featured".to_string()))
    {
        featured_project.featured = true;
    }

    projects
}

fn get_icon_for_url(url: String) -> String {
    if url.contains("github.com") {
        return "github".to_string();
    }
    // If the link is just the protocol and the domain then it's a website
    let domain_start = url.find("://");
    if let Some(domain_start) = domain_start {
        let domain = &url[domain_start + 3..];
        if url.contains("http") && !domain.contains("/") {
            return "website".to_string();
        }
    }
    "unknown".to_string()
}

fn extract_tags(description: &mut String) -> Vec<String> {
    let mut tmp_description = description.clone();
    let mut tags = vec![];
    let words: Vec<&str> = description.split(" ").collect();
    for word in words {
        let tag = word.trim_matches('_');
        if tag.starts_with('#') {
            let tag = &tag[1..];
            tags.push(tag.to_string());
            // Remove the tag from the description
            tmp_description = tmp_description.replace(word, "");
        }
    }
    *description = tmp_description;
    tags
}

fn extract_image(description: &mut String) -> String {
    let mut tmp_description = description.clone();
    let words: Vec<&str> = description.split(" ").collect();
    let mut image = "/public/images/default.jpg".to_string();
    for word in words {
        if word.starts_with("http") && (word.contains(".png") || word.contains(".jpg") || word.contains(".jpeg")) {
            image = word.to_string();
            // Remove the image from the description
            tmp_description = tmp_description.replace(word, "");
        }
    }
    *description = tmp_description;
    image
}

fn extract_links(description: &mut String) -> Vec<ProjectLink> {
    let mut tmp_description = description.clone();
    let mut links = vec![];
    while tmp_description.contains(['[', ']', '(', ')']) {
        // Extract link name
        let start_link_name = tmp_description.find('[').unwrap();
        let end_link_name = tmp_description.find(']').unwrap();
        let link_name = &tmp_description[start_link_name + 1..end_link_name];
        // Extract link URL
        let start_link_url = tmp_description.find('(').unwrap();
        let end_link_url = tmp_description.find(')').unwrap();
        let link_url = &tmp_description[start_link_url + 1..end_link_url];
        // Push the link to the list
        links.push(ProjectLink {
            name: link_name.to_string(),
            icon: get_icon_for_url(link_url.to_string()),
            url: link_url.to_string(),
        });
        // Remove the link from the description
        tmp_description =
            tmp_description.replace(&tmp_description[start_link_name..end_link_url + 1], "");
    }
    *description = tmp_description;
    links
}
