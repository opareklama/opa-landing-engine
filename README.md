# OPA Landing Engine

A high-performance, modular WordPress landing page engine developed by **OPA Reklama**. 

Features an extensible component architecture, drag-and-drop section building, automated migrations, and zero-maintenance deployment. Built specifically for modern real estate conversions and maximum SEO/AEO authority.

## 🚀 Key Features

*   **Modular Component Architecture:** Independent, self-contained sections (Hero, FAQ, Work Principles, etc.) built for extreme flexibility.
*   **Zero Data Loss Updates:** A robust `MigrationManager` ensures that plugin updates *never* overwrite existing client data, safely merging new settings dynamically.
*   **Automated Deployments:** A fully automated GitHub Action creates releases, strips development files, and builds a clean production package automatically on version bumps.
*   **Commercial-Grade Updates:** Powered by Plugin Update Checker, updates appear seamlessly in the WordPress Dashboard.
*   **SEO & AEO Optimized:** Clean, semantic HTML and structure designed to maximize entity authority.

## ⚙️ Architecture Deep-Dive

### The Registry Pattern
Components are registered dynamically via a centralized `ComponentRegistry`. This allows new features and sections to be injected gracefully without hardcoded dependencies, ensuring future scalability.

### Migration & State Management
Client configuration (text, SVGs, drag-and-drop ordering, toggles) is stored safely in `wp_options`. The custom state management merges new default values into the existing array, ensuring total data preservation across future component updates.

## 📥 Installation & Updates

Since this is an automated commercial engine:
1.  **Initial Install:** Download the latest ZIP from the **Releases** tab and upload it to your WordPress site.
2.  **Future Updates:** You will receive a standard WordPress update notification in your dashboard whenever a new release is published. Just click "Update".

## 🛠️ Development & Contribution

1.  Clone the repository.
2.  Run `composer install` to fetch development dependencies (if any).
3.  When a feature is complete, update the version number in `opa-landing-engine.php` and push to the `main` branch. 
4.  The GitHub Action will automatically handle the rest.

## 📄 License

This software is developed and maintained by **OPA Reklama**. 

---
*Developed with precision by [OPA Reklama](https://opareklama.lt)*
