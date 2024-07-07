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

## Features

### Designate a primary category

In order to designate a primary category for a post or a custom post type

- Load the post or custom post type
- Look for the `Primary Category` meta box on the side of the Wordpress editor
- Select the category
- Save/update the editor changes

You now have a primary category designated to your post or custom post type.

<sub>`Please remember to associate the category taxonomy to your custom post type in order to allow selecting a category and thus being able to designate a primary category.`</sub>

### Querying posts based on a primary category

The custom meta added by this plugin is `_primary_category`. This allows you to query posts and custom post types with a similar primary category on the front end using the WP_Query.

To easily test this, you can use a test shortcode provided by the plugin
`[primary_category_posts category="123" number="5" post_type="custom_post_type"]` in any post or page, where:

- `123` is the ID of the primary category you want to list posts for
- `number` is the number of posts to display
- `post_type` is the type of post you want to query (leave empty to include all public post types)

#### Example Usage

In the content editor of a post or page, you can add the shortcode like this:

```
[primary_category_posts category="123" number="5"]
```

Replace `123` with the ID of your primary category. If you want to specify a post type, you can do so:

```
[primary_category_posts category="123" number="5" post_type="custom_post_type"]
```

## TODO

- [ ] Implement linting
- [ ] Add primary category to url if permalink structure contains `%category%`
