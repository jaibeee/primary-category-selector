# Primary Category Selector

## Introduction

This project implements a Wordpress plugin that allows publishers to designate a primary category for posts or custom post types. It uses React for the custom Wordpress meta box UI.

## Usage

### Installation

1. Download [zip archive](https://github.com/jaibeee/primary-category-selector/archive/refs/heads/main.zip) of plugin from GitHub repository.
2. Sign in to WordPress.
3. In the left-hand menu, select Plugins > Add New.
4. Select Upload Plugin.
5. Select Choose File.
6. Locate and select the plugin . ...
7. Select Install Now.
8. Optional: Select Activate Plugin if you want the plugin to be active after the installation.

When the plugin is activated, you should now be able to go to any post or custom post type that has category as it's taxonomy, and set a primary category.

## Prerequisites

- [Node.js](https://nodejs.org/en/) (v20.0.x)
- npm or [pnpm](https://pnpm.io/) (v8.0.x)

## Development

Run the following command to install the dependencies:

```bash
pnpm install
```

### Development

Run the following command to start the development server using Nodemon:

```bash
npm run start
```

## TODO

- [ ] Implement linting
