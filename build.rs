use std::process::Command;

fn main() {
    println!("cargo:rerun-if-changed=templates/");
    // Run tailwind for the templates
    Command::new("npx")
        .args([
            "tailwindcss",
            "-i",
            "src/tailwind.css",
            "-o",
            "public/main.css",
        ])
        .status()
        .unwrap();
}
